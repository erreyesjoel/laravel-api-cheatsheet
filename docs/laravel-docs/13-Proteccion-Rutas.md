# Como proteger las rutas
1. Primero de todo, en nuestro api.php
- Tener un endpoint que devuelva el usuario autenticado
- Por defecto esta el /user con sanctum, pero nosotros lo hemos creado nosotros, el de jwt 
- Asi viene por defecto
```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
```
2. Tener un middleware personalizado para proteger las rutas, que en teoria lo hicimos nada mas hacer la autenticacion con jwt

- JwtCookieAuth.php
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtCookieAuth
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Leer token desde cookie
            $token = $request->cookie('access_token');

            if (!$token) {
                return response()->json(['error' => 'Token no encontrado'], 401);
            }

            // Validar token y autenticar usuario
            JWTAuth::setToken($token)->authenticate();

        } catch (\Exception $e) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        return $next($request);
    }
}
```

3. Tener registrado el middleware en bootstrap/app.php
```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // middleware personalizado JwtCookieAuth
        $middleware->alias([
            'jwtcookieauth' => \App\Http\Middleware\JwtCookieAuth::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
```

4. Ahora si en api /user, si usamos nuestro middleware personalizado JwtCookieAuth, funcionará y nos dará el usuario autenticado
```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/user', function (Request $request) {
    return auth()->user();
})->middleware('jwtcookieauth');
```
