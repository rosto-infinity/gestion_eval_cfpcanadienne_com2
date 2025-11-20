<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bilans_competences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('annee_academique_id')->constrained('annees_academiques')->onDelete('cascade');
            $table->decimal('moy_eval_semestre1', 5, 2)->nullable();
            $table->decimal('moy_eval_semestre2', 5, 2)->nullable();
            $table->decimal('moy_evaluations', 5, 2)->nullable();
            $table->decimal('moy_competences', 5, 2)->nullable();
            $table->decimal('moyenne_generale', 5, 2)->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'annee_academique_id'], 'bilan_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bilans_competences');
    }
};