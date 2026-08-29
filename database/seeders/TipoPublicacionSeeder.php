<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPublicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    DB::table('tipo_publicacion')->insert([
        ['nombre' => 'Noticia',             'slug' => 'noticias'],
        ['nombre' => 'Editorial',           'slug' => 'editoriales'],
        ['nombre' => 'Entrevista',          'slug' => 'entrevistas'],
        ['nombre' => 'Caricatura',          'slug' => 'caricaturas'],
        ['nombre' => 'Galería fotográfica', 'slug' => 'galerias'],
    ]);
}
}
