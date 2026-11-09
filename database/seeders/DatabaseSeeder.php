<?php

namespace Database\Seeders;

use App\Models\User;
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
        // 1. Creamos el Administrador de prueba
        User::updateOrCreate(
            ['email' => 'admin@petrescue.com'],
            [
                'name' => 'Administrador PetRescue',
                'password' => 'admin123', // Laravel lo encripta automáticamente por el cast 'hashed'
                'telefono_principal' => '3000000000',
                'role' => 'admin'
            ]
        );

        // 2. Creamos un Usuario normal de prueba
        User::updateOrCreate(
            ['email' => 'usuario@petrescue.com'],
            [
                'name' => 'Usuario Normal',
                'password' => 'user123',
                'telefono_principal' => '3111111111',
                'role' => 'user'
            ]
        );
    }
}
