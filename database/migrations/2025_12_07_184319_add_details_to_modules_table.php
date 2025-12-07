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
        Schema::table('modules', function (Blueprint $table): void {
            $table->foreignId('specialite_id')
                ->nullable()
                ->after('id')
                ->constrained('specialites')
                ->onDelete('cascade');

            $table->index('specialite_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table): void {
            $table->dropForeign(['specialite_id']);
            $table->dropIndex(['specialite_id']);
            $table->dropColumn('specialite_id');
        });
    }
};
