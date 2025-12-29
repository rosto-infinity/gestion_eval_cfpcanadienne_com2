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
        Schema::table('evaluations', function (Blueprint $table): void {
            // Ajouter la colonne specialite_id
            $table->foreignId('specialite_id')
                ->after('module_id')
                ->constrained('specialites')
                ->onDelete('restrict');

            // Ajouter un index pour améliorer les performances
            $table->index(['specialite_id', 'semestre', 'annee_academique_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluations', function (Blueprint $table): void {
            $table->dropForeign(['specialite_id']);
            $table->dropIndex(['specialite_id', 'semestre', 'annee_academique_id']);
            $table->dropColumn('specialite_id');
        });
    }
};
