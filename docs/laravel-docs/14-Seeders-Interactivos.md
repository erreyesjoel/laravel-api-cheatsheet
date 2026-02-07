# Seeders Interactivos
- Que se entiende o que son los seeders interactivos?
**Son seeders que se ejecutan de forma interactiva, es decir, que nos permiten interactuar con ellos a traves de la terminal, como hacer preguntas al usuario etc**
- Haremos un ejemplo para crear tareas de forma interactiva
- Pero primero de todo, veremos cuantos usuarios tenemos en nuestra base de datos
```sql
+----+-----------------+--------------------+-------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+
| id | name            | email              | email_verified_at | password                                                     | remember_token | created_at          | updated_at          |
+----+-----------------+--------------------+-------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+
|  1 | Joel Erreyes    | joel@erreyes.com   | NULL              | $2y$12$bqyfXJwL0zkRYgzUR8wTPeRasKQKMlnzqcsAcIC4M671hmrlynaOO | NULL           | 2026-02-07 22:48:19 | 2026-02-07 22:48:19 |
|  2 | Joel Erreyes 2  | joel2@erreyes.com  | NULL              | $2y$12$ubwDxqCtUNf1fygUd6bFC.FhcYT.kMmaxsYebl8rzNxjfmEbxY8aa | NULL           | 2026-02-07 22:48:20 | 2026-02-07 22:48:20 |
|  3 | Joel Erreyes 3  | joel3@erreyes.com  | NULL              | $2y$12$Wx8THlr4bN5Sbnf2cQU2gO4g0nr2m53Qxcb0OL/usvgnOIE1mZ7ma | NULL           | 2026-02-07 22:48:20 | 2026-02-07 22:48:20 |
|  4 | Joel Erreyes 4  | joel4@erreyes.com  | NULL              | $2y$12$s/ZNr1ba9AYtJIUHqqZdsuvKGs3i4whKopfrRa3QzNYgsJL3wZR1m | NULL           | 2026-02-07 22:48:20 | 2026-02-07 22:48:20 |
|  5 | Joel Erreyes 5  | joel5@erreyes.com  | NULL              | $2y$12$mqhybViu9z6Vh95BU7iOJ.KpiRP.sRsLziEKZYL4qKw06PXriveHe | NULL           | 2026-02-07 22:48:20 | 2026-02-07 22:48:20 |
|  6 | Joel Erreyes 6  | joel6@erreyes.com  | NULL              | $2y$12$NK.lnm630TtcE2hbqLWfNe1etlWijs0zhllwUtJwB84EQM/g5azby | NULL           | 2026-02-07 22:48:20 | 2026-02-07 22:48:20 |
|  7 | Joel Erreyes 7  | joel7@erreyes.com  | NULL              | $2y$12$5l7ltkz8u7jpraec2UhLE.D/UQNg/pA5KC5uSAg88bYJisiAkxK1G | NULL           | 2026-02-07 22:48:20 | 2026-02-07 22:48:20 |
|  8 | Joel Erreyes 8  | joel8@erreyes.com  | NULL              | $2y$12$5ODWxQycR0zcB6hQk/JKluJiSACGYpleKZttFcr1GsspOf31diuEq | NULL           | 2026-02-07 22:48:21 | 2026-02-07 22:48:21 |
|  9 | Joel Erreyes 9  | joel9@erreyes.com  | NULL              | $2y$12$c8tBtGe9cCSKaxjMkohLFej92OL47U15JWxA6JtuX9GcNoS3vufMi | NULL           | 2026-02-07 22:48:21 | 2026-02-07 22:48:21 |
| 10 | Joel Erreyes 10 | joel10@erreyes.com | NULL              | $2y$12$dyZ.osNBMxQ39l1TbZfZ3.tspc/815at/3BNh3.tKAAk3OR1tiWZ. | NULL           | 2026-02-07 22:48:21 | 2026-02-07 22:48:21 |
+----+-----------------+--------------------+-------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+
10 rows in set (0.00 sec)

mysql> 
```

1. Ahora si, podemos ir creando alguna tarea interactiva
- Yo prefiero hacerlo mediante un metodo separado en el TasksSeeder.php
- Asi quedaria entero, lo importante es el ->command
```php
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
```
2. Ejecutar el seeder, asi saldria
```bash
joel-erreyes:~/docsjoel/proyectos personales/laravel-api-cheatsheet/src$ php artisan db:seed
PHP Warning:  PHP Startup: Unable to load dynamic library 'pdo_mysql' (tried: /usr/lib/php/20220829/pdo_mysql (/usr/lib/php/20220829/pdo_mysql: cannot open shared object file: No such file or directory), /usr/lib/php/20220829/pdo_mysql.so (/usr/lib/php/20220829/pdo_mysql.so: undefined symbol: pdo_parse_params)) in Unknown on line 0

   INFO  Seeding database.  

  Database\Seeders\UsersSeeder ................................................................................................... RUNNING  
  Database\Seeders\UsersSeeder ............................................................................................. 1,686 ms DONE  

  Database\Seeders\TasksSeeder ................................................................................................... RUNNING  

 ¿Quieres crear tareas para todos los usuarios? (yes/no) [yes]:
 > 

 ¿Cuántas tareas por usuario? [2]:
 > 1

Creando 1 tareas para 10 usuarios...
Creando tareas para Joel Erreyes...
Creando tareas para Joel Erreyes 2...
Creando tareas para Joel Erreyes 3...
Creando tareas para Joel Erreyes 4...
Creando tareas para Joel Erreyes 5...
Creando tareas para Joel Erreyes 6...
Creando tareas para Joel Erreyes 7...
Creando tareas para Joel Erreyes 8...
Creando tareas para Joel Erreyes 9...
Creando tareas para Joel Erreyes 10...
¡Tareas creadas correctamente!
  Database\Seeders\TasksSeeder ............................................................................................. 3,983 ms DONE
```
3. Resultado en la base de datos, tabla tasks
```sql
+----+---------+------------------------------------------+-----------------------------------------------------------------------------+---------+----------+------------+---------------------+---------------------+
| id | user_id | title                                    | description                                                                 | status  | priority | due_date   | created_at          | updated_at          |
+----+---------+------------------------------------------+-----------------------------------------------------------------------------+---------+----------+------------+---------------------+---------------------+
|  1 |       1 | Task 1                                   | Description 1                                                               | pending | high     | 2022-12-31 | 2026-02-07 22:54:50 | 2026-02-07 22:54:50 |
|  2 |       1 | Tarea automática 1 para Joel Erreyes     | Esta es una tarea generada automáticamente para el usuario Joel Erreyes     | pending | medium   | 2026-02-26 | 2026-02-07 22:54:54 | 2026-02-07 22:54:54 |
|  3 |       2 | Tarea automática 1 para Joel Erreyes 2   | Esta es una tarea generada automáticamente para el usuario Joel Erreyes 2   | pending | medium   | 2026-02-14 | 2026-02-07 22:54:54 | 2026-02-07 22:54:54 |
|  4 |       3 | Tarea automática 1 para Joel Erreyes 3   | Esta es una tarea generada automáticamente para el usuario Joel Erreyes 3   | pending | medium   | 2026-02-23 | 2026-02-07 22:54:54 | 2026-02-07 22:54:54 |
|  5 |       4 | Tarea automática 1 para Joel Erreyes 4   | Esta es una tarea generada automáticamente para el usuario Joel Erreyes 4   | pending | medium   | 2026-02-11 | 2026-02-07 22:54:54 | 2026-02-07 22:54:54 |
|  6 |       5 | Tarea automática 1 para Joel Erreyes 5   | Esta es una tarea generada automáticamente para el usuario Joel Erreyes 5   | pending | medium   | 2026-02-22 | 2026-02-07 22:54:54 | 2026-02-07 22:54:54 |
|  7 |       6 | Tarea automática 1 para Joel Erreyes 6   | Esta es una tarea generada automáticamente para el usuario Joel Erreyes 6   | pending | medium   | 2026-02-19 | 2026-02-07 22:54:54 | 2026-02-07 22:54:54 |
|  8 |       7 | Tarea automática 1 para Joel Erreyes 7   | Esta es una tarea generada automáticamente para el usuario Joel Erreyes 7   | pending | medium   | 2026-03-04 | 2026-02-07 22:54:54 | 2026-02-07 22:54:54 |
|  9 |       8 | Tarea automática 1 para Joel Erreyes 8   | Esta es una tarea generada automáticamente para el usuario Joel Erreyes 8   | pending | medium   | 2026-03-09 | 2026-02-07 22:54:54 | 2026-02-07 22:54:54 |
| 10 |       9 | Tarea automática 1 para Joel Erreyes 9   | Esta es una tarea generada automáticamente para el usuario Joel Erreyes 9   | pending | medium   | 2026-02-24 | 2026-02-07 22:54:54 | 2026-02-07 22:54:54 |
| 11 |      10 | Tarea automática 1 para Joel Erreyes 10  | Esta es una tarea generada automáticamente para el usuario Joel Erreyes 10  | pending | medium   | 2026-02-21 | 2026-02-07 22:54:54 | 2026-02-07 22:54:54 |
+----+---------+------------------------------------------+-----------------------------------------------------------------------------+---------+----------+------------+---------------------+---------------------+
11 rows in set (0.00 sec)

mysql> 
```
