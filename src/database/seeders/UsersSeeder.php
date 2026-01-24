<?php

namespace Database\Seeders;
use App\Models\User; // importamos el modelo User
use Illuminate\Support\Facades\Hash; // importamos el facade Hash, para que encripte la contraseña
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Joel Erreyes',
            'email' => 'joel@erreyes.com',
            'password' => Hash::make('password'),
        ]);
    }
}
