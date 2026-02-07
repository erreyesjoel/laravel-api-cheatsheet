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
    }

    public function tareasInteractivas(){
        
    }
}
