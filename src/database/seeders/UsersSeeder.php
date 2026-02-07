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

        User::create([
            'name' => 'Joel Erreyes 2',
            'email' => 'joel2@erreyes.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Joel Erreyes 3',
            'email' => 'joel3@erreyes.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Joel Erreyes 4',
            'email' => 'joel4@erreyes.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Joel Erreyes 5',
            'email' => 'joel5@erreyes.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Joel Erreyes 6',
            'email' => 'joel6@erreyes.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Joel Erreyes 7',
            'email' => 'joel7@erreyes.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Joel Erreyes 8',
            'email' => 'joel8@erreyes.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Joel Erreyes 9',
            'email' => 'joel9@erreyes.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Joel Erreyes 10',
            'email' => 'joel10@erreyes.com',
            'password' => Hash::make('password'),
        ]);
    }
}
