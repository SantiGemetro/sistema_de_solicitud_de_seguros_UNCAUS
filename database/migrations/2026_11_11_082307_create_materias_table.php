
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materia', function (Blueprint $table) {
            $table->increments('id_materia'); //para que el identificador sea compatible con un INT UNSIGNED y unsignedInteger() para su clave foránea.

            $table->string('nombre', 100);

            $table->unsignedInteger('id_carrera');

            $table->foreign('id_carrera')
                ->references('id_carrera')
                ->on('carrera')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->unique(['id_carrera', 'nombre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materia');
    }
};
