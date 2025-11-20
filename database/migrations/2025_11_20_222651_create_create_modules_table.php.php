<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table): void {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('intitule', 100);
            $table->decimal('coefficient', 4, 2)->default(1.00);
            $table->tinyInteger('ordre')->unsigned();
            $table->timestamps();

            $table->index('ordre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
