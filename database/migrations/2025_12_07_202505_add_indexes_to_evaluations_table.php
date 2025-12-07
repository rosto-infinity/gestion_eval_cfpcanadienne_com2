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
        Schema::table('evaluations', function (Blueprint $table) {
            // Ajouter un index composite pour améliorer les performances
            $table->index(['user_id', 'semestre', 'annee_academique_id'], 'evaluations_user_semestre_annee_index');
            
            // Index pour la contrainte unique (éviter les doublons)
            $table->unique(['user_id', 'module_id', 'semestre', 'annee_academique_id'], 'evaluations_unique_constraint');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropIndex('evaluations_user_semestre_annee_index');
            $table->dropUnique('evaluations_unique_constraint');
        });
    }
};