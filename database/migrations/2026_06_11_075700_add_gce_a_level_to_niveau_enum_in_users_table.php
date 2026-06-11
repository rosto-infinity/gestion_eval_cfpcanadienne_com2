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
            $table->enum('niveau', Niveau::values())
                ->default(Niveau::BEPC->value)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->enum('niveau', ['3eme', 'bepc', 'premiere', 'probatoire', 'terminale', 'bacc', 'licence', 'cep'])
                ->default('bepc')
                ->change();
        });
    }
};
