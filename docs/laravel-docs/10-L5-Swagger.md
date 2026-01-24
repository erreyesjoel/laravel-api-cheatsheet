# Instalación limpia de L5‑Swagger 10 (OpenAPI 3.1)

## 1. Instalar L5‑Swagger 10

**Usamos L5‑Swagger 10 porque es la única versión compatible con Laravel 10/11, swagger‑php 6, php 8.1+, atributos PHP y OpenAPI 3.1. Las versiones anteriores no sirven para proyectos modernos**

```bash
composer require darkaonline/l5-swagger:^10.0
```

## 2. Publicar configuración y vistas

```bash
php artisan vendor:publish --provider="L5Swagger\L5SwaggerServiceProvider"
```

## 3. Generar documentación
```bash
php artisan l5-swagger:generate
```

## 4. Acceder a la documentación

```bash
/api/documentation
```

## 5. Para que la api nos salga en la UI Swagger
- Debemos documentarlo nosotros, no es automatico en Laravel, como en FastAPI
- Ejemplo con metodo logout en AuthController.php
```php
 // documentacion de logout
    #[OA\Post(
    path: "/api/logout",
    summary: "Cerrar sesión",
    tags: ["Auth"],
    responses: [
        new OA\Response(
            response: 200,
            description: "Logout correcto",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "message",
                        type: "string",
                        example: "Logout correcto"
                    )
                ]
            )
        ),
        new OA\Response(
            response: 400,
            description: "No se pudo cerrar sesión",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "error",
                        type: "string",
                        example: "No se pudo cerrar sesión"
                    )
                ]
            )
        )
    ]
)]
    public function logout(Request $request)
{
    try {
        // 1. Invalidar access token si existe
        if ($request->cookie('access_token')) {
            JWTAuth::setToken($request->cookie('access_token'))->invalidate();
        }

        // 2. Invalidar refresh token si existe
        if ($request->cookie('refresh_token')) {
            JWTAuth::setToken($request->cookie('refresh_token'))->invalidate();
        }

        // 3. Borrar cookies
        $clearAccess = cookie()->forget('access_token');
        $clearRefresh = cookie()->forget('refresh_token');

        return response()->json([
            'message' => 'Logout correcto'
        ])->withCookie($clearAccess)
          ->withCookie($clearRefresh);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'No se pudo cerrar sesión'
        ], 400);
    }
}
```

- Despúes ejecutar 
```bash
php artisan l5-swagger:generate
```

- Y acceder a la documentación en 
```bash
/api/documentation
```

- Ya veremos nuestra api en ui swagger