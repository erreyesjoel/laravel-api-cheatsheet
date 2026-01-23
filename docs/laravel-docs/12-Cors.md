# 🟩 ¿Qué es CORS?

### CORS (Cross‑Origin Resource Sharing) es una regla del navegador que dice:

- “Solo puedes hacer peticiones a otro dominio si ese servidor te lo permite explícitamente.”

### Ejemplo de “otro dominio”:

- Frontend → http://127.0.0.1:5173
- Backend → http://127.0.0.1:8001

**Aunque parezcan iguales, son orígenes distintos, y el navegador los bloquea por defecto.**

- En Laravel, debes configurar el archivo `config/cors.php` para permitir las peticiones.
- Ejemplo **ALLOWED ORIGINS**
```php
<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // IMPORTANTE: aquí NO puede ir '*'
    'allowed_origins' => [
        'http://127.0.0.1:5173',
        'http://localhost:5173',
    ],

    'allowed_origins_patterns' => [],

    // Necesario para enviar cookies HTTP-Only
    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    // Necesario para credentials: "include"
    'supports_credentials' => true,

];
```

Esto le dice al navegador:
- “Sí, acepto peticiones desde este frontend concreto, y sí, puedes enviar cookies.”

## 🟢 Resumen en una frase
CORS es un guardia de seguridad del navegador.