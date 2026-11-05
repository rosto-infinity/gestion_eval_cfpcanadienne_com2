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
        Schema::create('institution_arretes', function (Blueprint $table): void {
            $table->id();
            $table->enum('type', ['principal', 'visa'])->default('visa');
            $table->string('numero')->nullable();
            $table->date('date_arrete')->nullable();
            $table->text('texte');
            $table->integer('ordre')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institution_arretes');
    }
};
