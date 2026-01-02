<?php

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
        Schema::table('users', function (Blueprint $table) {
             // ═══════════════════════════════════════════════════════════
            // INFORMATIONS CIVILES
            // ═══════════════════════════════════════════════════════════
           
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance', 100)->nullable();
            $table->string('nationalite', 50)->default('Camerounaise');
            
            // ═══════════════════════════════════════════════════════════
            // CONTACT
            // ═══════════════════════════════════════════════════════════
            $table->string('telephone', 20)->nullable();
            $table->string('telephone_urgence', 20)->nullable()->comment('Contact personne à prévenir');
            $table->text('adresse')->nullable();
            
            // ═══════════════════════════════════════════════════════════
            // DOCUMENTS
            // ═══════════════════════════════════════════════════════════
          
            $table->string('piece_identite')->nullable()->comment('CNI/Passeport');
            
            // ═══════════════════════════════════════════════════════════
            // STATUT & SÉCURITÉ
            // ═══════════════════════════════════════════════════════════
            $table->enum('statut', ['actif', 'inactif', 'suspendu', 'archive'])
                  ->default('actif')
                  ->comment('actif=compte opérationnel | inactif=temporaire | suspendu=sanction | archive=diplômé/démission');
            // ═══════════════════════════════════════════════════════════
            // INDEX POUR PERFORMANCES
            // ═══════════════════════════════════════════════════════════
            $table->index('email');
            $table->index('statut');
            $table->index('created_at'); // Tri par date d'inscription
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
