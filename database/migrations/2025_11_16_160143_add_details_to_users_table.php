<?php

use App\Enums\Niveau;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('matricule', 20)->unique()->default('');
            $table->enum('sexe', ['M', 'F', 'Autre'])->default('M');
            $table->string('profile')->nullable();
            $table->enum('niveau', Niveau::values())->default(Niveau::BEPC->value);
            
            $table->foreignId('specialite_id')
                ->constrained('specialites')
                ->onDelete('restrict');
            
            $table->foreignId('annee_academique_id')
                ->constrained('annees_academiques')
                ->onDelete('restrict');
            
            $table->softDeletes();
            $table->index(['specialite_id', 'annee_academique_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'matricule',
                'sexe',
                'profile',
                'niveau',
                'specialite_id',
                'annee_academique_id',
                'deleted_at'
            ]);
        });
    }
};
