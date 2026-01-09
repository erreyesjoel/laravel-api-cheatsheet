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
