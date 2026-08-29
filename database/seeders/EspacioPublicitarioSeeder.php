<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspacioPublicitarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('espacio_publicitario')->insert([
            ['clave' => 'HOME_SUPERIOR',   'nombre' => 'Portada - banner superior'],
            ['clave' => 'HOME_LATERAL',    'nombre' => 'Portada - columna lateral'],
            ['clave' => 'ARTICULO_FINAL',  'nombre' => 'Artículo - pie de nota'],
            ['clave' => 'LISTADO_LATERAL', 'nombre' => 'Listados - columna lateral'],
        ]);
    }
}
