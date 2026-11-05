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
        Schema::create('specialite_competences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialite_id')->constrained('specialites')->cascadeOnDelete();
            $table->string('intitule');
            $table->text('description')->nullable();
            $table->unsignedInteger('ordre')->default(0);
            $table->timestamps();

            $table->index(['specialite_id', 'ordre']);
        });

        if (! Schema::hasColumn('attestations', 'competences_supplementaires')) {
            Schema::table('attestations', function (Blueprint $table) {
                $table->json('competences_supplementaires')->nullable()->after('visas_arretes');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('attestations', 'competences_supplementaires')) {
            Schema::table('attestations', function (Blueprint $table) {
                $table->dropColumn('competences_supplementaires');
            });
        }

        Schema::dropIfExists('specialite_competences');
    }
};
