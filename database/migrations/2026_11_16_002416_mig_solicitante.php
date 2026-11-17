<?php

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
        Schema::table('solicitante', function (Blueprint $table) {
            $table->renameColumn('correo', 'correo_solicitante');
            $table->string('correo_solicitante', 255)->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitante', function (Blueprint $table) {
            $table->renameColumn('correo_solicitante', 'correo');
        });
    }
};
