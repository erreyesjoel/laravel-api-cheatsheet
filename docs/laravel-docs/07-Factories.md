# 🟦 ¿Qué son los factories?
- Los factories en Laravel sirven para generar datos falsos de manera automática usando Faker.
- Se usan principalmente para:
- testing
- poblar la base de datos con datos de prueba
- generar muchos registros rápidamente
- simular escenarios reales

**Son la forma moderna y profesional de crear datos en Laravel**

### 🟩 ¿Cómo se crea un factory?
1. Crear un factory con Artisan
```bash
php artisan make:factory UserFactory --model=User
```
- Esto crea:
- UserFactory.php -> database/factories/UserFactory.php

## 🟦 ¿Cómo luce un factory por defecto?
- El de users ya viene por defecto
```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
```
- Laravel usa fake() (Faker) para generar datos realistas.

## 🟩 ¿Cómo usar un factory?
✔ Crear un solo usuario    
```php
User::factory()->create();
```
✔ Crear un usuario con datos personalizados
```php
User::factory()->create([
    'name' => 'Joel',
    'email' => 'joel@example.com',
]);
```
✔ Crear varios usuarios
```php
User::factory(10)->create();
```

## 🟦 Usar factories dentro de seeders
Ejemplo en UsersSeeder.php:
```php
public function run(): void
{
    User::factory(10)->create(); // 10 usuarios falsos

    User::factory()->create([
        'name' => 'Joel',
        'email' => 'joel@example.com',
    ]);
}
```
## 🟧 ¿Qué es Faker?
- Faker es la librería que genera datos falsos:
- nombres
- emails
- direcciones
- textos
- números
- fechas
Ejemplos
```php
fake()->name();
fake()->email();
fake()->address();
fake()->text(200);
fake()->numberBetween(1, 100);
```

## 🟩 Factories con relaciones 
Ejemplo: un Post pertenece a un User.
PostFactory:
```php
public function definition(): array
{
    return [
        'title' => fake()->sentence(),
        'content' => fake()->paragraph(),
        'user_id' => User::factory(), // crea un usuario automáticamente
    ];
}
```
Esto demuestra que entiendes relaciones Eloquent.

## 🟦 Ejecutar factories desde Tinker (muy útil)
```bash
php artisan tinker
```
Dentro:
```php
User::factory(5)->create();
```

### ⭐ Diferencia entre Seeders y Factories 
| Herramienta | Para qué sirve |
| --- | --- |
| Factory | Generar datos falsos para testing o desarrollo |
| Seeder | Insertar datos reales o iniciales (admin, roles, configuraciones) |

# Resumen
- Hay 3 formas de ejecutar factories:
## 🟩 A) Desde un seeder (lo más común)
```php
User::factory(10)->create();
```
Esto sí se ejecuta cuando corres:
```bash
php artisan db:seed
```
O
```bash
php artisan migrate:fresh --seed
```
## 🟩 B) Desde Tinker
```bash
php artisan tinker
```
Y dentro:
```php
User::factory()->create();
User::factory(50)->create();
```

## 🟩 C) Desde tests (su uso principal)
```php
public function test_users_can_be_created()
{
    $user = User::factory()->create();

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
    ]);
}
```
