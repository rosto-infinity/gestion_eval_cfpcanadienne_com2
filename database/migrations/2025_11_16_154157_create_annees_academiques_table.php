<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('annees_academiques', function (Blueprint $table) {
            $table->id();
            $table->string('libelle', 20)->unique();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annees_academiques');
    }
};