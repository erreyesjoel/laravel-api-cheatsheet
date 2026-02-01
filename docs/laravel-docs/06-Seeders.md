# Creacion de seeders
### Para que sirven los seeders?
Los seeders son archivos que permiten insertar datos en la base de datos de manera masiva.

## Como se crean?
### 1. Con comando o por interfaz, como queramos
- Por comando ejemplo:
```bash
php artisan make:seeder UsersSeeder
```

- Esto crea un archivo en la carpeta database/seeders
- UsersSeeder.php -> database/seeders/UsersSeeder.php
- Asi se ve nada mas creado con el comando
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }
}
```
### 2. Registrar el seeder en DatabaseSeeder.php
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
        ]);
    }
}
```

## Ejecutar el seeder
```bash
php artisan db:seed --class=UsersSeeder
```

## Ejecutar todos los seeders
```bash
php artisan db:seed
```

## Resetear base de datos + seeders (muy útil en desarrollo)
```bash
php artisan migrate:refresh --seed
```

**Comprobacion de que se ha creado el usuario**
- Consultas sql dentro de mi base de datos (docker)
```bash
mysql> SELECT * FROM users;
+----+--------------+------------------+-------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+
| id | name         | email            | email_verified_at | password                                                     | remember_token | created_at          | updated_at          |
+----+--------------+------------------+-------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+
|  1 | Joel Erreyes | joel@erreyes.com | NULL              | $2y$12$D0lyOwC97q3vAaecjxJtHeVmhXnvXsZrqdNhLRSpXFg4VyU.h6ll6 | NULL           | 2026-01-15 19:56:44 | 2026-01-15 19:56:44 |
+----+--------------+------------------+-------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+
1 row in set (0.00 sec)

mysql> SELECT name FROM users Where id = 1;
+--------------+
| name         |
+--------------+
| Joel Erreyes |
+--------------+
1 row in set (0.00 sec)

mysql> 
```

### ⭐ Pro Tip: Relaciones robustas
Evita poner IDs a mano (`user_id => 1`), ya que si borras usuarios o cambias de base de datos, el ID 1 podría no existir o ser otra persona.

**Mala práctica:**
```php
'user_id' => 1 // ❌ Si el usuario 1 no existe, falla
```

**Buena práctica:**
Busca por un campo único (email, slug, etc.) y si no existe, créalo.
```php
$user = User::where('email', 'joel@erreyes.com')->first();

if (!$user) {
    $user = User::factory()->create(['email' => 'joel@erreyes.com']);
}

Task::create([
    // ...
    'user_id' => $user->id // ✅ Siempre funciona
]);
```

- Ejemplo completo
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
        // 1. Buscamos el usuario por su email (Más seguro y explícito que ID 1)
        $user = User::where('email', 'joel@erreyes.com')->first();

        // 2. Fallback: Si no existe (ej. DB vacía), lo creamos
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Joel Erreyes',
                'email' => 'joel@erreyes.com',
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
}
```
