<?php

namespace Database\Seeders;

// use App\Models\User;
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
    }
}
