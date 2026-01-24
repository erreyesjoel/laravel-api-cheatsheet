### Creacion de modelos
- El comando estándar de Laravel para crear un modelo és:
```bash
php artisan make:model Task
```
- Eso creará el modelo Task para la tabla Tasks
```bash
app/Models/Task.php
```
- Asi se ve el modelo nada más crearlo con ese comando
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
}
```
## 🟧 ✔ Si quieres crear el modelo + controlador API (opcional)
```bash
php artisan make:model Task -c --api
```
Esto crea:
- Modelo
- Controlador API
## 🟩 Comando para crear modelo + migración al mismo tiempo
```bash
php artisan make:model Task -m
```
## 🟦 Variantes útiles
### ✔ Modelo + migración + factory
```bash
php artisan make:model Task -mf
```
### ✔ Modelo + migración + controlador API
```bash
php artisan make:model Task -mc --api
```
### ✔ Modelo + migración + factory + seeder + controller
```bash
php artisan make:model Task -mfs -c
```

### Relaciones entre tablas (migraciones) FK
- Como en este caso entre Tasks y Users, Tasks es la N (tabla hija), ponemos la foreign key en la migracion de tasks
```php
// Relación con users
$table->foreignId('user_id')->constrained()->onDelete('cascade');
```
**Explicación:**
- foreignId('user_id') → crea la columna user_id
- constrained() → asume que referencia id en la tabla users
- onDelete('cascade') → si se borra un usuario, se borran sus tareas
**Migracion completa**
```php
Schema::create('tasks', function (Blueprint $table) {
    $table->id();

    // Relación con users
    $table->foreignId('user_id')
          ->constrained()
          ->onDelete('cascade');

    $table->string('title');
    $table->text('description')->nullable();
    $table->enum('status', ['pending', 'in_progress', 'done'])->default('pending');
    $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
    $table->date('due_date')->nullable();
    $table->timestamps();
});
```
## 🟦 Migración de users (tabla padre)
- La tabla users no necesita ninguna referencia a tasks.
- Es la tabla padre, así que no lleva foreign keys.
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});
```
### Definir las relaciones en los modelos
- Laravel usa Eloquent para definir relaciones entre modelos
## 🟦 Relación en el modelo User (1 → N)
- Un usuario tiene muchas tareas:
```php
   // un usuario tiene MUCHAS tareas
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
```
- Esto permite:
```php
$user->tasks; // todas las tareas del usuario
```
## 🟧 Relación en el modelo Task (N → 1)
- Una tarea pertenece a un usuario
```php
    // Una tarea pertenece a un usuario
    public function user()
    {
    return $this->belongsTo(User::class);    
    }
```
- Esto permite:
```php
$task->user; // el usuario dueño de la tarea
```

### 🟩 Resumen 

| Tipo relación | Dónde está la FK | Modelo A | Modelo B |
|--------------|------------------|----------|----------|
| **1:N**      | En la tabla **N** | `belongsTo()` | `hasMany()` |
| **1:1**      | En una de las dos | `belongsTo()` | `hasOne()` |
| **N:M**      | En tabla **pivot** | `belongsToMany()` | `belongsToMany()` |

---

### 🟦 Ejemplos rápidos

#### ✔ 1:N (Users → Tasks)
- **FK:** `tasks.user_id`  
- **Task →** `belongsTo(User)`  
- **User →** `hasMany(Task)`

---

#### ✔ 1:1 (User → Profile)
- **FK:** `profiles.user_id`  
- **Profile →** `belongsTo(User)`  
- **User →** `hasOne(Profile)`

---

#### ✔ N:M (Users ↔ Roles)
- **FK:** en tabla pivot `role_user`  
- **User →** `belongsToMany(Role)`  
- **Role →** `belongsToMany(User)`

---

### ⭐ Regla de oro 

- `belongsTo()` **va donde está la foreign key**  
- `hasOne()` / `hasMany()` **van en el otro lado**  
- `belongsToMany()` **se usa cuando hay tabla pivot**
