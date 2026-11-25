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
        Schema::table('formulario', function (Blueprint $table) {
            $table->enum('estado', ['pendiente', 'avalado/listo', 'enviado', 'cancelado'])
                  ->default('pendiente')->change();
            $table->string('token_acceso', 64)->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formulario', function (Blueprint $table) {
            $table->enum('estado', ['pendiente', 'avalado/listo', 'enviado'])->default('pendiente')->change();
            $table->dropColumn('token_acceso');
        });
    }
};
