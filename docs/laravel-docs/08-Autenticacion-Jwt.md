# Autenticacion con jwt, access token y refresh token
1. Instalar paquete jwt
```shell
composer require tymon/jwt-auth
```

2. Publicar la configuracion, esto nos creara config/jwt.php
```shell
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```
3. Generar la clave secreta
```
php artisan jwt:secret
```
- Eso nos pondrá la linea jwt_Secret de forma automatica en nuestro .env

4. En app/Models/User.php, añadimos

**Esto es obligatorio para que JWTAuth pueda generar tokens (los metodos)**

```php
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
```


5. Creamos el controller
```shell
php artisan make:controller AuthController
```
- Contenido del controller
- Tymon jwt no tiene refresh token por defecto, por eso lo creamos nosotros
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$accessToken = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        $refreshToken = JWTAuth::claims([
            'exp' => now()->addDays(7)->timestamp
        ])->fromUser(JWTAuth::user());

        // Cookies seguras, HTTP Only, SameSite=Lax
        $accessCookie = cookie(
            'access_token',
            $accessToken,
            config('jwt.ttl'), // minutos, viene del fichero config/jwt.php
            null,
            null,
            true,   // secure (solo HTTPS)
            true,   // httpOnly
            false,  // raw
            'Lax'   // SameSite
        );
        $refreshCookie = cookie(
            'refresh_token',
            $refreshToken,
            60 * 24 * 7, // 7 días
            null,
            null,
            true,
            true,
            false,
            'Lax'
        );

        return response()->json([
            'message' => 'Login correcto'
        ])->withCookie($accessCookie)
          ->withCookie($refreshCookie);
    }

    public function refresh(Request $request)
    {
        $refreshToken = $request->input('refresh_token');
        try {
            $newAccessToken = JWTAuth::setToken($refreshToken)->refresh();

            $accessCookie = cookie(
                'access_token',
                $newAccessToken,
                config('jwt.ttl'),
                null,
                null,
                true,
                true,
                false,
                'Lax'
            );

            return response()->json(['message' => 'Token refrescado'])->withCookie($accessCookie);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Refresh token inválido'], 401);
        }
    }
}
```

6. api.php
```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);
```

7. Esta bien esto, para proteger rutas, que requieran autenticacion

¿Falta algo en el backend?
Solo si quieres proteger rutas, añade el middleware JWT (auth:api o jwt.auth) en las rutas que requieran autenticación.

Ejemplo
```php
<?php
Route::get('/perfil', function () {
    // Solo accesible si tienes un access token válido, deberemos añadir el middleware jwtcookieauth que lo creamos despues
})->middleware(['jwtcookieauth', 'jwt.auth'])
```

8. Middleware personalizado, para poder usar el middleware jwt.auth en las rutas que requieran autenticacion
```bash
php artisan make:middleware JwtCookieAuth
```

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Este middleware es necesario porque el paquete JWTAuth de Laravel
 * espera el token JWT en el header Authorization.
 *
 * Sin embargo, en este proyecto el token se guarda en una cookie HTTP Only ('access_token').
 *
 * El middleware copia el token de la cookie al header Authorization antes de que actúe jwt.auth,
 * permitiendo así que las rutas protegidas funcionen correctamente con autenticación por cookie.
 */
class JwtCookieAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Si existe la cookie 'access_token', la ponemos en el header Authorization
        if ($request->hasCookie('access_token')) {
            $token = $request->cookie('access_token');
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }
        return $next($request);
    }
}
```

- Registrar el Middleware en bootstrap/app.php

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
10. Registro
- AuthController.php
- Añadimos el metodo
```php
   public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generar tokens igual que en login
        $accessToken = JWTAuth::fromUser($user);

        $accessCookie = cookie(
            'access_token',
            $accessToken,
            config('jwt.ttl'),
            null,
            null,
            true,
            true,
            false,
            'Lax'
        );

        $refreshToken = JWTAuth::claims([
            'exp' => now()->addDays(7)->timestamp
        ])->fromUser($user);

        $refreshCookie = cookie(
            'refresh_token',
            $refreshToken,
            60 * 24 * 7,
            null,
            null,
            true,
            true,
            false,
            'Lax'
        );

        return response()->json([
            'message' => 'Usuario registrado correctamente'
        ])->withCookie($accessCookie)
        ->withCookie($refreshCookie);
    }
```
- api.php
```php
Route::post('/register', [AuthController::class, 'register']);
```