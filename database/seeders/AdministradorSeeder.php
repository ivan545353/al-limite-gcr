<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdministradorSeeder extends Seeder
{
    public function run(): void
    {
        $password = env('ADMIN_INITIAL_PASSWORD');

        if (blank($password)) {
            $this->command->error(
                'Falta ADMIN_INITIAL_PASSWORD en el archivo de entorno. '
                . 'No se creo el administrador inicial.'
            );
            return;
        }

        DB::table('usuario')->insert([
            'nombre'                => 'Administrador',
            'apellido'              => 'Inicial',
            'email'                 => env('ADMIN_INITIAL_EMAIL', 'gordocomunitario@gmail.com'),
            'password_hash'         => Hash::make($password),
            'rol'                   => 'ADMINISTRADOR',
            'rol_publico'           => 'Dirección',
            'activo'                => true,
            'debe_cambiar_password' => true,
            'fecha_creacion'        => now(),
        ]);
    }
}
