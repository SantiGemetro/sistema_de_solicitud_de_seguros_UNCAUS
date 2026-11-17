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
            $table->renameColumn('profesor_dni_profesor', 'dni_profesor');
            $table->renameColumn('formulario_id_formulario', 'id_formulario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nomina_profesores', function (Blueprint $table) {
            //
        });
    }
};
