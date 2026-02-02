<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = ['Playa', 'Montaña', 'Ciudad', 'Crucero', 'Aventura'];
        foreach ($tipos as $nombre) {
            \App\Models\Tipo::create(['nombre' => $nombre]);
        }
    }
}
