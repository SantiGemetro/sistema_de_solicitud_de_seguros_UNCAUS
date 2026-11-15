<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     //para que coordinador conecte con user de laravel o algo así
     */
    public function up(): void
    {
        Schema::table('coordinador', function (Blueprint $table) {
            $table->foreignId('id_usuario')
                ->nullable() //si ya hay coordinadores registrados, inicialmente no tendr[ia cuenta laravel]
                ->unique()
                ->constrained('users')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('coordinador', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);
            $table->dropUnique(['id_usuario']);
            $table->dropColumn('id_usuario');
        });
    }
};
