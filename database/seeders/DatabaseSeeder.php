<?php

namespace Database\Seeders;

// use App\Models\User;
use App\Models\Coordinador;
use App\Models\Operador;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Operador::updateOrCreate(
            ['correo' => 'op1@gmail.com'],
            [
                'nombre' => 'op1',
                'contraseña' => 'op123',
            ]
        );
        Coordinador::updateOrCreate(
            ['nombre' => 'cordi1'],
            [
                'correo' => 'cordi1@uncaus.edu.ar',
                'contraseña' => 'cordi1',
                'telefono' => '+54 9 364 400-0000',
                'tipo' => 'carrera',
                'carrera' => 'Licenciatura en Administración',
                'firma_aclaracion' => '',
            ]
        );
    }
}
