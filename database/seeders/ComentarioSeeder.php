<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vacacion;
use App\Models\User;
use App\Models\Comentario;

class ComentarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vacaciones = Vacacion::all();
        $users = User::all();

        if($users->count() == 0) {
            $this->command->info('No hay usuarios para asignar comentarios.');
            return;
        }

        foreach ($vacaciones as $vacacion) {
            // Add 2 comments per vacation
            for ($i = 0; $i < 2; $i++) {
                Comentario::create([
                    'idvacacion' => $vacacion->id,
                    'iduser' => $users->random()->id,
                    'texto' => $this->getRandomComment(),
                    'puntuacion' => rand(3, 5), // Mostly positive reviews
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }

    private function getRandomComment()
    {
        $comments = [
            '¡Una experiencia increíble! Sin duda repetiré.',
            'El lugar es precioso, pero la comida podría mejorar.',
            'Todo perfecto, la organización de 10.',
            'Me encantó cada momento, muy recomendable.',
            'Un viaje inolvidable, gracias por todo.',
            'Las vistas eran espectaculares, tal como en las fotos.',
            'Buena relación calidad-precio.',
            'Disfrutamos mucho en familia, actividades muy divertidas.',
            'El hotel superó mis expectativas.',
            'Atención al cliente excelente en todo momento.',
        ];

        return $comments[array_rand($comments)];
    }
}
