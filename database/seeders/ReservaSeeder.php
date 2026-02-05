<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Vacacion;

class ReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $vacaciones = Vacacion::all();

        if ($users->count() == 0 || $vacaciones->count() == 0) {
            $this->command->info('No hay usuarios o vacaciones para crear reservas.');
            return;
        }

        // Create 10 random reservations
        for ($i = 0; $i < 10; $i++) {
            $date = now()->subDays(rand(1, 60)); // Random date in last 60 days
            Reserva::create([
                'iduser' => $users->random()->id,
                'idvacacion' => $vacaciones->random()->id,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
