<?php

declare(strict_types=1);

use App\Enums\Role;
use App\Models\AnneeAcademique;
use App\Models\Attestation;
use App\Models\InstitutionArrete;
use App\Models\Specialite;
use App\Models\User;

beforeEach(function (): void {
    $this->admin = User::factory()->create([
        'role' => Role::ADMIN,
    ]);

    $this->annee = AnneeAcademique::first() ?? AnneeAcademique::create([
        'libelle' => '2025-2026',
        'date_debut' => '2025-10-13',
        'date_fin' => '2026-10-12',
        'is_active' => true,
    ]);

    $this->specialite = Specialite::where('code', 'GP')->first() ?? Specialite::create([
        'code' => 'GP',
        'intitule' => 'Graphisme de production',
    ]);

    $this->student = User::factory()->create([
        'role' => Role::USER,
        'specialite_id' => $this->specialite->id,
        'annee_academique_id' => $this->annee->id,
        'name' => 'MENEAM KAPTUE Falone',
        'sexe' => 'F',
        'date_naissance' => '2005-08-02',
        'lieu_naissance' => 'Bafoussam',
    ]);
});

test('admin can access attestations par specialite page', function (): void {
    $response = $this->actingAs($this->admin)
        ->get(route('attestations.par-specialite', [
            'annee_id' => $this->annee->id,
            'specialite_id' => $this->specialite->id,
        ]));

    $response->assertStatus(200);
    $response->assertSee('Attestations de Fin de Formation');
    $response->assertSee('MENEAM KAPTUE FALONE');
});

test('admin can preview student attestation HTML', function (): void {
    $response = $this->actingAs($this->admin)
        ->get(route('attestations.apercu', $this->student->id));

    $response->assertStatus(200);
    $response->assertSee('MENEAM KAPTUE FALONE');
    $response->assertSee('Graphisme de production');
});

test('admin can generate batch attestations PDF with custom dates and custom specialite', function (): void {
    $response = $this->actingAs($this->admin)
        ->post(route('attestations.generer-lot-pdf'), [
            'annee_academique_id' => $this->annee->id,
            'specialite_id' => $this->specialite->id,
            'date_debut' => '2025-10-13',
            'date_fin' => '2026-09-21',
            'date_delivrance' => '2026-10-01',
            'lieu_delivrance' => 'Bafoussam',
            'arrete_principal' => 'Créé et agréé, renouvelé par Arrêté ministériel N° 000355/ MINEFOP/SG/DFOP/SDGSF/SBACD/CBAC',
            'visas_arretes' => [
                "Vu l'Arrêté n° 159/MINEFOP/SG/DFOP/SDGSF/SACD du 03 avril 2020 portant agrément du Centre de Formation Professionnelle La Canadienne ;",
            ],
            'selected_users' => [$this->student->id],
            'students' => [
                $this->student->id => [
                    'specialite_personnalisee' => 'Graphisme & Design Multimédia',
                    'date_debut' => '2025-10-13',
                    'date_fin' => '2026-09-21',
                ],
            ],
        ]);

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/pdf');

    // Vérifier l'enregistrement en base
    $attestation = Attestation::where('user_id', $this->student->id)->first();
    expect($attestation)->not->toBeNull();
    expect($attestation->specialite_libelle)->toBe('Graphisme & Design Multimédia');
    expect($attestation->specialite_personnalisee)->toBe('Graphisme & Design Multimédia');
    expect($attestation->token)->not->toBeEmpty();
});

test('public verification page displays certified information for valid token', function (): void {
    $attestation = Attestation::create([
        'user_id' => $this->student->id,
        'annee_academique_id' => $this->annee->id,
        'specialite_id' => $this->specialite->id,
        'specialite_libelle' => 'Graphisme de production',
        'date_debut' => '2025-10-13',
        'date_fin' => '2026-09-21',
        'date_delivrance' => '2026-10-01',
        'lieu_delivrance' => 'Bafoussam',
        'numero_attestation' => 'ATT-2026-GP-0001',
        'token' => Attestation::generateToken(),
        'arrete_principal' => 'Créé et agréé par Arrêté',
        'visas_arretes' => ['Vu arrêté 1'],
    ]);

    $response = $this->get(route('attestations.verifier.public', ['token' => $attestation->token]));

    $response->assertStatus(200);
    $response->assertSee('DOCUMENT OFFICIEL VÉRIFIÉ & CERTIFIÉ', false);
    $response->assertSee('MENEAM KAPTUE FALONE');
    $response->assertSee('Graphisme de production');
});

test('public verification page returns 404 for invalid token', function (): void {
    $response = $this->get(route('attestations.verifier.public', ['token' => 'invalid-token-12345']));

    $response->assertStatus(404);
});

test('admin can manage institution arretes and visas', function (): void {
    // Accès page
    $response = $this->actingAs($this->admin)->get(route('settings.arretes.index'));
    $response->assertStatus(200);

    // Ajout d'un nouveau visa
    $storeResponse = $this->actingAs($this->admin)->post(route('settings.arretes.store'), [
        'type' => 'visa',
        'numero' => 'TEST/MINEFOP/2026',
        'date_arrete' => '2026-01-15',
        'texte' => "Vu l'Arrêté n° TEST/MINEFOP/2026 portant agrément complémentaire",
        'ordre' => 5,
        'is_active' => true,
    ]);

    $storeResponse->assertRedirect(route('settings.arretes.index'));

    $visa = InstitutionArrete::where('numero', 'TEST/MINEFOP/2026')->first();
    expect($visa)->not->toBeNull();
    expect($visa->is_active)->toBeTrue();

    // Toggle statut
    $toggleResponse = $this->actingAs($this->admin)->get(route('settings.arretes.toggle', $visa->id));
    $toggleResponse->assertRedirect();
    expect($visa->fresh()->is_active)->toBeFalse();
});
