<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->foreignId('specialite_id')->after('id')->constrained('specialites')->onDelete('cascade');
            $table->index('specialite_id');
        });
    }

    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropForeign(['specialite_id']);
            $table->dropColumn('specialite_id');
        });
    }
};