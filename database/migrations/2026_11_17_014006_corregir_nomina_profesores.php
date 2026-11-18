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
        Schema::table('nomina_profesores', function (Blueprint $table) {
            $table->unique(['id_formulario', 'dni_profesor'], 'nomina_profesores_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nomina_profesores', function (Blueprint $table) {
            $table->dropUnique('nomina_profesores_unique'); //eliminar el unique
        });
        Schema::table('nomina_profesores', function (Blueprint $table) {
            $table->renameColumn('dni_profesor', 'profesor_dni_profesor');
            $table->renameColumn('id_formulario', 'formulario_id_formulario');
        });
    }
};
