# Como hacemos Api's en Laravel?
1. Debemos instalar el "stack"
```bash
php artisan install:api
```
Este comando:
- Configura Laravel Sanctum para autenticación por tokens
- Prepara middleware para APIs
- Añade configuración base para proyectos tipo REST
- Deja el proyecto listo para crear endpoints -> nos creará en routes/ el archivo api.php, donde definimos las rutas de api
- api.php nada mas hacer el comando de install api
```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
```
2. Creamos una api de prueba, en api.php
```php
// api de prueba GET
Route::get('/test', function () {
    return response()->json([
        'message' => 'API funcionando correctamente',
        'status' => 'ok'
    ]);
});
```
- Si ejecutamos con php artisan serve
- Veremos nuestra api en esta ruta -> http://127.0.0.1:8001/api/test
