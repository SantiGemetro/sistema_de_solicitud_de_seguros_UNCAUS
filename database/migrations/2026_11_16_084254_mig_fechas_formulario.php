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
        Schema::table('fechas_formulario', function (Blueprint $table) {
            $table->dropColumn([
                'fecha_inicio',
                'fecha_fin'
            ]);
            //nuevos campos
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fechas_formulario', function (Blueprint $table) {
            $table->dropColumn([
                'fecha',
                'hora_inicio',
                'hora_fin'
            ]);

            $table->date('fecha_inicio');
            $table->date('fecha_fin');
        });
    }
};
