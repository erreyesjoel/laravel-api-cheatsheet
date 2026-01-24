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

5. Ahora en react, en un user.service.ts, crearemos una funcion para obtener el usuario autenticado
```ts
import { API_URL } from "../../environment-variables/environments";

export const UserService = {
    getUser: async () => {
        const res = await fetch(`${API_URL}/user`, {
            method: "GET",
            credentials: "include",
        });
        return res.json();
    },
};
```

6. Ahora en el Auth.tsx, cuando hagamos login o registro, llamaremos a esta funcion para obtener el usuario autenticado
- Prueba con console.log 
```tsx
console.log("User:", await UserService.getUser())
```
- Auth.tsx completo
```tsx
import styles from './Auth.module.scss'
import { useState } from 'react'
import { AuthService } from '../../api/services/auth.service'
import { useNavigate } from 'react-router-dom'
import { UserService } from '../../api/services/user.service'

const Auth = () => {
    const navigate = useNavigate()
    const [isRegister, setIsRegister] = useState(false)

    // Estados para email y password
    const [email, setEmail] = useState("")
    const [password, setPassword] = useState("")

    // Manejar submit del formulario
    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault() // evitar recarga

        if (!isRegister) {
            // LOGIN
            try {
                const res = await AuthService.login({ email, password })
                console.log("Login response:", res)
                navigate("/dashboard") // redirigir a dashboard
                // prueba para ver si coge el usuario autenticado
                console.log("User:", await UserService.getUser())

            } catch (error) {
                console.error("Error en login:", error)
            }
        } else {
            // REGISTER
            try {
                const res = await AuthService.register({ email, password })
                console.log("Register response:", res)
                navigate("/dashboard") // redirigir a dashboard
                console.log("User:", await UserService.getUser())

            } catch (error) {
                console.error("Error en registro:", error)
            }
        }
    }

    return (
        <div className={styles.authContainer}>
            <div className={styles.authCard}>
                <h1>{isRegister ? "Crear cuenta" : "Iniciar sesion"}</h1>

                {/* Formulario */}
                <form className={styles.formAuth} onSubmit={handleSubmit}>

                    {/* Email */}
                    <div>
                        <input
                            className={styles.inputsAuth}
                            type="email"
                            id="email"
                            placeholder="correo@ejemplo.com"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                        />
                    </div>

                    {/* Password */}
                    <div>
                        <input
                            className={styles.inputsAuth}
                            type="password"
                            id="password"
                            placeholder="********"
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                        />
                    </div>

                    {/* Confirmar contraseña solo si es registro*/}
                    {isRegister && (
                        <div>
                            <input
                                className={styles.inputsAuth}
                                type="password"
                                id="name"
                                placeholder="Confirmar contraseña"
                            />
                        </div>
                    )}

                    {/* Botón con clase */}
                    <button className={styles.btnAuth} type="submit">
                        {isRegister ? "Registrarse" : "Entrar"}
                    </button>

                    {/* Cambiar entre login y registro */}
                    <p className={styles.textAuth}>
                        {isRegister ? (
                            <>
                                ¿Ya tienes cuenta?{" "}
                                {/* Si es registro, mostramos a Inicia sesión */}
                                <a className={styles.linkAuth} onClick={() => setIsRegister(false)}>
                                    Inicia sesión
                                </a>
                            </>
                        ) : (
                            <>
                                ¿No tienes cuenta?{" "}
                                {/* Si es login, mostramos a Regístrate */}
                                <a className={styles.linkAuth} onClick={() => setIsRegister(true)}>
                                    Regístrate
                                </a>
                            </>
                        )}
                    </p>
                </form>
            </div>
        </div>
    )
}

export default Auth
```
