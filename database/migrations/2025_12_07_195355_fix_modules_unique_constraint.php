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
        Schema::table('modules', function (Blueprint $table) {
            // Supprimer l'ancienne contrainte unique sur 'code'
            $table->dropUnique('modules_code_unique');
            
            // Ajouter une contrainte unique composite (specialite_id + code)
            $table->unique(['specialite_id', 'code'], 'modules_specialite_code_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            // Supprimer la contrainte composite
            $table->dropUnique('modules_specialite_code_unique');
            
            // Remettre l'ancienne contrainte unique sur 'code'
            $table->unique('code', 'modules_code_unique');
        });
    }
};