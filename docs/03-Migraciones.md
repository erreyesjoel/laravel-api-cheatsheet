### Migraciones en Laravel
- Una migración és un archivo PHP que define cambios en la base de datos (crear tablas, modificarlas o eliminarlas)
- Una misma migración puede crear una o varias tablas, siempre que lo hagas dentro del metodo up()
### Formas de crear una migración
## 🟩 Comando para crear una migración nueva
- Queremos crear la migracion de la tabla tasks por ejemplo:
```bash
php artisan make:migration create_tasks_table
```
- **Laravel** generarà un archivo en:
```bash
src/database/migrations/xxxx_xx_xx_xxxxxx_create_tasks_table.php
```
### Orden de ejecución de las migraciones
- Es muy importante el orden de ejecución de las migraciones porque Laravel crea las tablas siguiendo el orden en que aparecen los archivos de migración.
- Si una migración depende de otra (por ejemplo, una tabla que contiene claves foráneas hacia otra tabla), la tabla “padre” debe existir antes que la tabla “hija”
- Si el orden es incorrecto, Laravel no podrá crear las claves foráneas y la migración fallará.
- Por eso, en un sistema como un gestor de tareas, la tabla users debe crearse antes que la tabla tasks, ya que tasks suele contener un user_id que referencia a users.id
- **En resumen: el orden garantiza la integridad referencial y evita errores al crear relaciones entre tablas**
## Como lo haremos en nuestro caso, users y tasks, le cambiaremos los nombres a todas, para que estén bien ordenadas
- Para evitar que se vean similar a esto: 2026_01_07_174500_create_tasks_table.php
1. Crear migracion tasks
```bash
php artisan make:migration create_tasks_table
```
- La estructura de una migracion recién creada con el comando, queda así
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
```
2. Migración (fichero php) hecho para la tabla tasks
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // Relación con users
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Campos principales
            $table->string('title');
            $table->text('description')->nullable();

            // Estado y prioridad, por defecto tarea en pendiente
            $table->enum('status', ['pending', 'in_progress', 'done'])
                  ->default('pending');
            
            $table->enum('priority', ['low', 'medium', 'high'])
                  ->default('medium');
            
            // Fecha límite
            $table->date('due_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
```
- Ejecutamos migraciones, normal o con :fresh
- En este caso con php artisan migrate tal cual sirve
```bash
joel-erreyes:~/docsjoel/proyectos personales/laravel-api-cheatsheet/src$ php artisan migrate
PHP Warning:  PHP Startup: Unable to load dynamic library 'pdo_mysql' (tried: /usr/lib/php/20220829/pdo_mysql (/usr/lib/php/20220829/pdo_mysql: cannot open shared object file: No such file or directory), /usr/lib/php/20220829/pdo_mysql.so (/usr/lib/php/20220829/pdo_mysql.so: undefined symbol: pdo_parse_params)) in Unknown on line 0

   INFO  Running migrations.  

  2026_01_07_180635_create_tasks_table ......................................................................... 51.60ms DONE
```

3. Ahora si queremos las podemos ordenar, actualmente están así:
```bash
joel-erreyes:~/docsjoel/proyectos personales/laravel-api-cheatsheet/src$ ls database/migrations/
0001_01_01_000000_create_users_table.php  0001_01_01_000002_create_jobs_table.php
0001_01_01_000001_create_cache_table.php  2026_01_07_180635_create_tasks_table.php
joel-erreyes:~/docsjoel/proyectos personales/laravel-api-cheatsheet/src$ 
```
1. Debemos borrar todas las tablas creadas por migraciones
```bash
php artisan migrate:reset
```
2. Renombrar los archivos como nosotros queramos
Ejemplo:
```bash
01_users.php
02_cache.php
03_jobs.php
04_tasks.php
```
3. Ejecutamos migraciones otra vez
```bash
php artisan migrate
```
**TODO ESTO ES OPCIONAL, PERO SI QUEREMOS HACERLO...**