<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\InstitutionArrete;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstitutionArreteController extends Controller
{
    /**
     * Liste et gestion des arrêtés ministériels et visas
     */
    public function index(): View
    {
        $principal = InstitutionArrete::principal()->first();
        $visas = InstitutionArrete::visas()->orderBy('ordre', 'asc')->get();

        return view('settings.arretes.index', compact('principal', 'visas'));
    }

    /**
     * Enregistrer un nouvel arrêté / visa
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:principal,visa',
            'numero' => 'nullable|string|max:255',
            'date_arrete' => 'nullable|date',
            'texte' => 'required|string',
            'ordre' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['ordre'] = $validated['ordre'] ?? (InstitutionArrete::where('type', $validated['type'])->max('ordre') + 1);
        $validated['is_active'] = $request->boolean('is_active', true);

        // Si principal, s'assurer qu'il n'y en a qu'un actif
        if ($validated['type'] === 'principal') {
            InstitutionArrete::where('type', 'principal')->update(['is_active' => false]);
            $validated['is_active'] = true;
        }

        InstitutionArrete::create($validated);

        return redirect()->route('settings.arretes.index')
            ->with('success', 'Arrêté / Visa enregistré avec succès.');
    }

    /**
     * Mettre à jour un arrêté existant
     */
    public function update(Request $request, InstitutionArrete $arrete): RedirectResponse
    {
        $validated = $request->validate([
            'numero' => 'nullable|string|max:255',
            'date_arrete' => 'nullable|date',
            'texte' => 'required|string',
            'ordre' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $arrete->update($validated);

        return redirect()->route('settings.arretes.index')
            ->with('success', 'Arrêté mis à jour avec succès.');
    }

    /**
     * Supprimer un visa
     */
    public function destroy(InstitutionArrete $arrete): RedirectResponse
    {
        if ($arrete->type === 'principal') {
            return back()->with('error', "Impossible de supprimer l'arrêté principal.");
        }

        $arrete->delete();

        return redirect()->route('settings.arretes.index')
            ->with('success', 'Visa supprimé avec succès.');
    }

    /**
     * Activer/Désactiver rapidement un visa
     */
    public function toggle(InstitutionArrete $arrete): RedirectResponse
    {
        $arrete->update(['is_active' => ! $arrete->is_active]);

        return back()->with('success', 'Statut du visa mis à jour.');
    }
}
