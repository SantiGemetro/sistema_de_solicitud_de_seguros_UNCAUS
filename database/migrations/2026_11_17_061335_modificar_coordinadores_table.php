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
        Schema::table('coordinador', function (Blueprint $table) {
            $table->string('carrera', 155)->nullable()->after('tipo');
            DB::statement("ALTER TABLE coordinador MODIFY COLUMN tipo ENUM('area', 'carrera') NOT NULL;"); //convertir en enum
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coordinador', function (Blueprint $table) {
            $table->dropColumn('carrera');
        });
    }
};
