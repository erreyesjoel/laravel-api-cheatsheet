<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buscadmos el usuario por su email (Más seguro y explícito que ID 1)
        $user = User::where('email', 'joel@erreyes.com')->first();

        // 2. Fallback: Si no existe (ej. DB vacía), lo creamos
        if (!$user) {
            $user = User::create([
                'name' => 'Joel Erreyes',
                'email' => 'joel@erreyes.com',
                'password' => 'password',
            ]);
        }

        Task::create([
            'title' => 'Task 1',
            'description' => 'Description 1',
            'status' => 'pending',
            'priority' => 'high',
            'due_date' => '2022-12-31',
            // Usamos el ID del usuario real en lugar de '1' a secas
            'user_id' => $user->id,
        ]);

        $this->tareasInteractivas();
    }

    public function tareasInteractivas()
    {
        // Preguntamos si quiere crear tareas para los usuarios
        // si la respuesta es No, no se crearán tareas
        if ($this->command->confirm('¿Quieres crear tareas para todos los usuarios?', true)) {
            
            // Pedimos la cantidad de tareas por usuario
            $count = (int) $this->command->ask('¿Cuántas tareas por usuario?', 2);

            // Obtenemos todos los usuarios
            $users = User::all();
            
            $this->command->info("Creando $count tareas para {$users->count()} usuarios...");

            foreach ($users as $user) {
                $this->command->info("Creando tareas para {$user->name}...");
                
                for ($i = 1; $i <= $count; $i++) {
                    Task::create([
                        'title' => "Tarea automática $i para {$user->name}",
                        'description' => "Esta es una tarea generada automáticamente para el usuario {$user->name}",
                        'status' => 'pending',
                        'priority' => 'medium',
                        'due_date' => now()->addDays(rand(1, 30)),
                        'user_id' => $user->id,
                    ]);
                }
            }
            
            $this->command->info('¡Tareas creadas correctamente!');
        }
    }
}
