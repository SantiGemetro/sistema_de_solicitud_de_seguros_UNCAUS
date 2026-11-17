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
        //hago el cambio en bloques separados porque algunas versiones de laravel pueden dar problemas si se ejecuta otra cosa despues de renameColumn, al parecer
        Schema::table('nomina_estudiantes', function (Blueprint $table) {
            $table->renameColumn('estudiante_dni_estudiante', 'dni_estudiante'); //cambiar los atributos de la tabla pivote para que coincidan con los nombres de las relaciones en el modelo Formulario
            $table->renameColumn('formulario_id_formulario', 'id_formulario');
        });
        Schema::table('nomina_estudiantes', function (Blueprint $table) {
            $table->unique(['id_formulario', 'dni_estudiante'],
            'nomina_estudiantes_unique'); //hacerlos unique
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nomina_estudiantes', function (Blueprint $table) {
            $table->dropUnique('nomina_estudiantes_unique'); //eliminar el unique
        });
        Schema::table('nomina_estudiantes', function (Blueprint $table) {
            $table->renameColumn('dni_estudiante', 'estudiante_dni_estudiante');
            $table->renameColumn('id_formulario', 'formulario_id_formulario');
        });
    }
};
