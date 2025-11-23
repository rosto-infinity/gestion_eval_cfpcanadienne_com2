<?php

declare(strict_types=1);

use App\Enums\Niveau;
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
        Schema::table('users', function (Blueprint $table): void {
            $table->string('matricule', 20)
                ->nullable()
                ->after('password')
                ->unique()->nullable();
            $table->enum('sexe', ['M', 'F', 'Autre'])->default('M')
                ->after('matricule')->nullable();
            $table->string('profile')
                ->after('sexe')->nullable();
            $table->enum('niveau', Niveau::values())->default(Niveau::BEPC->value)
                ->after('profile');

            $table->foreignId('specialite_id')
                ->after('niveau')
                ->nullable()
                ->constrained('specialites')
                ->onDelete('cascade');

            $table->foreignId('annee_academique_id')
                ->after('specialite_id')
                ->nullable()
                ->constrained('annees_academiques')
                ->onDelete('cascade');

            $table->softDeletes()
                ->after('annee_academique_id');
            $table->index(['specialite_id', 'annee_academique_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn([
                'matricule',
                'sexe',
                'profile',
                'niveau',
                'specialite_id',
                'annee_academique_id',
                'deleted_at',
            ]);
        });
    }
};
