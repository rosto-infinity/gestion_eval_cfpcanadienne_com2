<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attestations', function (Blueprint $table): void {
            $table->id();

            // Références étudiant & parcours
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('annee_academique_id')->constrained('annees_academiques')->cascadeOnDelete();
            $table->foreignId('specialite_id')->nullable()->constrained('specialites')->nullOnDelete();

            // Spécialité imprimée
            $table->string('specialite_personnalisee')->nullable();
            $table->string('specialite_libelle');

            // Tranche de dates de formation
            $table->date('date_debut');
            $table->date('date_fin');

            // Délivrance
            $table->string('lieu_delivrance')->default('Bafoussam');
            $table->date('date_delivrance');

            // Référence unique & Token QR code
            $table->string('numero_attestation')->unique();
            $table->string('token', 64)->unique();

            // Snapshot des arrêtés en vigueur
            $table->text('arrete_principal');
            $table->json('visas_arretes');

            // Métadonnées
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['annee_academique_id', 'specialite_id']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attestations');
    }
};
