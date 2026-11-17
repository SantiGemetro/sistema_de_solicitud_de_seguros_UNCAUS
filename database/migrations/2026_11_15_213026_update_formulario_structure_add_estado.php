<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * esto es para modificar los atributos de formulario
     */
    public function up(): void
    {
        Schema::table('formulario', function (Blueprint $table) {
            // 1. Eliminar las claves foráneas usando los nombres exactos de la base de datos
            $table->dropForeign('fk_fomulario_coordinador1');
            $table->dropForeign('fk_formulario_operador_de_BE1');

            // 2. Eliminar las columnas que ya no se necesitan
            $table->dropColumn(['id_coordinador_avala', 'id_operador_confirma']);

            // 3. Agregar la columna de estado 
            $table->enum('estado', ['pendiente', 'avalado/listo', 'enviado'])
                  ->default('pendiente')
                  ->after('carrera');
        });
    }

    /**
     * Reverse the migrations. En caso de que necesitemos revertir
     */
    public function down(): void
    {
        Schema::table('formulario', function (Blueprint $table) {
            // Revertir cambios en caso de rollback
            $table->integer('id_coordinador_avala')->nullable();
            $table->integer('id_operador_confirma')->nullable();

            $table->foreign('id_coordinador_avala', 'fk_fomulario_coordinador1')
                  ->references('id_coordinador')
                  ->on('coordinador');

            $table->foreign('id_operador_confirma', 'fk_formulario_operador_de_BE1')
                  ->references('id_operador_de_BE')
                  ->on('operador_de_be');

            $table->dropColumn('estado');
        });
    }
};
