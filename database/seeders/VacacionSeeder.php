<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VacacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Type IDs dynamically
        $playa = \App\Models\Tipo::where('nombre', 'Playa')->first()->id ?? 1;
        $montana = \App\Models\Tipo::where('nombre', 'Montaña')->first()->id ?? 2;
        $ciudad = \App\Models\Tipo::where('nombre', 'Ciudad')->first()->id ?? 3;
        $crucero = \App\Models\Tipo::where('nombre', 'Crucero')->first()->id ?? 4;
        $aventura = \App\Models\Tipo::where('nombre', 'Aventura')->first()->id ?? 5;

        $vacaciones = [
            // PLAYA
            [
                'data' => [
                    'titulo' => 'Bora Bora Luxury Escape',
                    'descripcion' => 'Sumérgete en el lujo absoluto en un bungalow sobre el agua en Bora Bora. Disfruta de aguas turquesas cristalinas, arrecifes de coral vibrantes y un servicio de primera clase. Ideal para lunas de miel o escapadas románticas.',
                    'precio' => 5000.00,
                    'idtipo' => $playa,
                    'pais' => 'Polinesia Francesa'
                ],
                'imagenes' => [
                    'images/seed/playa_bora_bora_1_1770072239497.png',
                    'images/seed/playa_bora_bora_2_1770072252258.png',
                    'images/seed/playa_bora_bora_3_1770072265960.png'
                ]
            ],

            // MONTAÑA
            [
                'data' => [
                    'titulo' => 'Refugio Invernal en Dolomitas',
                    'descripcion' => 'Vive la magia de los Alpes italianos en un acogedor chalet de madera. Esquía en pistas de clase mundial, disfruta de la gastronomía local y relájate frente a la chimenea con vistas a las montañas nevadas.',
                    'precio' => 2800.00,
                    'idtipo' => $montana,
                    'pais' => 'Italia'
                ],
                'imagenes' => [
                    'images/seed/montana_dolomites_1_1770072292240.png',
                    'images/seed/montana_dolomites_2_1770072302664.png',
                    'images/seed/montana_dolomites_3_1770072314529.png'
                ]
            ],

            // CIUDAD
            [
                'data' => [
                    'titulo' => 'Dubai Futurista',
                    'descripcion' => 'Explora la ciudad del futuro. Desde el rascacielos más alto del mundo, el Burj Khalifa, hasta los zocos tradicionales llenos de especias y oro. Compras de lujo, safaris por el desierto y arquitectura impresionante te esperan.',
                    'precio' => 3500.00,
                    'idtipo' => $ciudad,
                    'pais' => 'Emiratos Árabes Unidos'
                ],
                'imagenes' => [
                    'images/seed/ciudad_dubai_1_1770072335410.png',
                    'images/seed/ciudad_dubai_2_1770072348014.png',
                    'images/seed/ciudad_dubai_3_1770072359839.png'
                ]
            ],

            // CRUCERO
            [
                'data' => [
                    'titulo' => 'Crucero por los Fiordos Noruegos',
                    'descripcion' => 'Navega a través de paisajes impresionantes con acantilados verdes, cascadas majestuosas y aguas tranquilas. Disfruta de la comodidad de un crucero de lujo mientras exploras la belleza natural de Noruega.',
                    'precio' => 4200.00,
                    'idtipo' => $crucero,
                    'pais' => 'Noruega'
                ],
                'imagenes' => [
                    'images/seed/crucero_fjords_1_1770072371780.png',
                    'images/seed/crucero_fjords_2_1770072384148.png',
                    'images/seed/crucero_fjords_3_1770072396216.png'
                ]
            ],

            // AVENTURA
            [
                'data' => [
                    'titulo' => 'Expedición Costa Rica',
                    'descripcion' => 'Adéntrate en la exuberante selva tropical de Costa Rica. Camina por puentes colgantes, descubre cascadas escondidas y observa tucanes y perezosos en su hábitat natural. Pura vida y aventura garantizada.',
                    'precio' => 2100.00,
                    'idtipo' => $aventura,
                    'pais' => 'Costa Rica'
                ],
                'imagenes' => [
                    'images/seed/aventura_costa_rica_1_1770072416103.png',
                    'images/seed/aventura_costa_rica_2_1770072431896.png',
                    'images/seed/aventura_costa_rica_3_1770072444349.png'
                ]
            ]
        ];

        foreach ($vacaciones as $v) {
            $vacacion = \App\Models\Vacacion::create($v['data']);
            
            foreach ($v['imagenes'] as $img) {
                \App\Models\Foto::create([
                    'idvacacion' => $vacacion->id,
                    'ruta' => $img
                ]);
            }
        }
    }
}
