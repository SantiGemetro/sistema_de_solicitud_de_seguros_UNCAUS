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
        //Hacemos una tabla aparte que relaciona una verificacion con un formulario
        //esto porque un solo correo (verificado) puede hacer varias solicitudes
        Schema::create('verificaciones_correo', function (Blueprint $table) {
            $table->id();
            $table->integer(('id_formulario'))->index();
            $table->string('token_hash', 64)->unique();

            $table->timestamp('expira_at');
            $table->timestamp('verificado_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verificaciones_correo');
    }
};
