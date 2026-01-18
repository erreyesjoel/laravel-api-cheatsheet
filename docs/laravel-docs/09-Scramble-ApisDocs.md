# 🌀 Scramble — Qué es y para qué sirve

**Scramble** es un generador automático de documentación **OpenAPI (Swagger)** para proyectos **Laravel**.  
Su objetivo es crear documentación profesional de tu API **sin que tengas que escribir anotaciones manuales** ni mantener archivos YAML/JSON a mano.

---

## 🚀 ¿Qué hace Scramble?

Scramble analiza tu proyecto Laravel y genera automáticamente:

- **Esquema OpenAPI 3.1** (`openapi.json` / `openapi.yaml`)
- **Documentación navegable** usando Stoplight Elements
- **Modelos y tipos** basados en tus clases, validaciones y controladores
- **Ejemplos de requests/responses**
- **Esquemas de validación** a partir de Form Requests
- **Documentación siempre actualizada** según tu código real

---

## 🧠 ¿Cómo funciona?

Scramble inspecciona:

- Rutas (`Route::getRoutes()`)
- Controladores y métodos
- Tipos de parámetros
- Reglas de validación (`FormRequest`)
- Modelos y propiedades
- Respuestas devueltas por tus endpoints

Con esa información genera automáticamente un documento OpenAPI completo.

No necesitas escribir:

- anotaciones `@OA\...`
- YAML manual
- JSON manual
- comentarios especiales

---

## 🎨 ¿Cómo se ve la documentación?

Scramble usa **Stoplight Elements**, una UI moderna y elegante para mostrar:

- Endpoints
- Parámetros
- Ejemplos
- Modelos
- Esquemas
- Autenticación
- Respuestas

Es como Swagger UI, pero más bonito y moderno.

---

## 🆚 Scramble vs Swagger clásico

| Característica | Swagger clásico | Scramble |
|----------------|----------------|----------|
| Requiere anotaciones | Sí | No |
| Generación automática | Parcial | Completa |
| UI moderna | No | Sí (Stoplight) |
| Integración con Laravel | Básica | Profunda |
| Mantiene docs actualizadas | Manual | Automático |

---

## 🎯 ¿Para qué sirve Scramble?

- Documentar APIs Laravel de forma profesional  
- Generar OpenAPI para Postman, Insomnia o SDKs  
- Mantener documentación sincronizada con el código  
- Evitar errores y documentación obsoleta  
- Mostrar tu API a clientes, equipos o portfolio  
- Tener documentación moderna sin esfuerzo  

---

## 🏁 Resumen

Scramble es:

> **“Swagger/OpenAPI para Laravel, pero automático, moderno y sin anotaciones.”**

Perfecto para proyectos donde quieres documentación profesional sin pelearte con YAML, anotaciones o herramientas rotas.

## Instalacion y configuracion
1. Instalar scramble via composer
```bash
composer require dedoc/scramble
```
- Salida terminal
```bash
  INFO  Discovering packages.  

  dedoc/scramble .................................................................................................................... DONE
  ```

2. Publicar la configuracion de scramble
```bash
php artisan vendor:publish --provider="Dedoc\Scramble\ScrambleServiceProvider" --tag="scramble-config"
```
- Eso nos creará config/scramble.php
- Asi viene por defecto
```php
<?php

use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;

return [
    /*
     * Your API path. By default, all routes starting with this path will be added to the docs.
     * If you need to change this behavior, you can add your custom routes resolver using `Scramble::routes()`.
     */
    'api_path' => 'api',

    /*
     * Your API domain. By default, app domain is used. This is also a part of the default API routes
     * matcher, so when implementing your own, make sure you use this config if needed.
     */
    'api_domain' => null,

    /*
     * The path where your OpenAPI specification will be exported.
     */
    'export_path' => 'api.json',

    'info' => [
        /*
         * API version.
         */
        'version' => env('API_VERSION', '0.0.1'),

        /*
         * Description rendered on the home page of the API documentation (`/docs/api`).
         */
        'description' => '',
    ],

    /*
     * Customize Stoplight Elements UI
     */
    'ui' => [
        /*
         * Define the title of the documentation's website. App name is used when this config is `null`.
         */
        'title' => null,

        /*
         * Define the theme of the documentation. Available options are `light`, `dark`, and `system`.
         */
        'theme' => 'light',

        /*
         * Hide the `Try It` feature. Enabled by default.
         */
        'hide_try_it' => false,

        /*
         * Hide the schemas in the Table of Contents. Enabled by default.
         */
        'hide_schemas' => false,

        /*
         * URL to an image that displays as a small square logo next to the title, above the table of contents.
         */
        'logo' => '',

        /*
         * Use to fetch the credential policy for the Try It feature. Options are: omit, include (default), and same-origin
         */
        'try_it_credentials_policy' => 'include',

        /*
         * There are three layouts for Elements:
         * - sidebar - (Elements default) Three-column design with a sidebar that can be resized.
         * - responsive - Like sidebar, except at small screen sizes it collapses the sidebar into a drawer that can be toggled open.
         * - stacked - Everything in a single column, making integrations with existing websites that have their own sidebar or other columns already.
         */
        'layout' => 'responsive',
    ],

    /*
     * The list of servers of the API. By default, when `null`, server URL will be created from
     * `scramble.api_path` and `scramble.api_domain` config variables. When providing an array, you
     * will need to specify the local server URL manually (if needed).
     *
     * Example of non-default config (final URLs are generated using Laravel `url` helper):
     *
     * ```php
     * 'servers' => [
     *     'Live' => 'api',
     *     'Prod' => 'https://scramble.dedoc.co/api',
     * ],
     * ```
     */
    'servers' => null,

    /**
     * Determines how Scramble stores the descriptions of enum cases.
     * Available options:
     * - 'description' – Case descriptions are stored as the enum schema's description using table formatting.
     * - 'extension' – Case descriptions are stored in the `x-enumDescriptions` enum schema extension.
     *
     *    @see https://redocly.com/docs-legacy/api-reference-docs/specification-extensions/x-enum-descriptions
     * - false - Case descriptions are ignored.
     */
    'enum_cases_description_strategy' => 'description',

    /**
     * Determines how Scramble stores the names of enum cases.
     * Available options:
     * - 'names' – Case names are stored in the `x-enumNames` enum schema extension.
     * - 'varnames' - Case names are stored in the `x-enum-varnames` enum schema extension.
     * - false - Case names are not stored.
     */
    'enum_cases_names_strategy' => false,

    /**
     * When Scramble encounters deep objects in query parameters, it flattens the parameters so the generated
     * OpenAPI document correctly describes the API. Flattening deep query parameters is relevant until
     * OpenAPI 3.2 is released and query string structure can be described properly.
     *
     * For example, this nested validation rule describes the object with `bar` property:
     * `['foo.bar' => ['required', 'int']]`.
     *
     * When `flatten_deep_query_parameters` is `true`, Scramble will document the parameter like so:
     * `{"name":"foo[bar]", "schema":{"type":"int"}, "required":true}`.
     *
     * When `flatten_deep_query_parameters` is `false`, Scramble will document the parameter like so:
     *  `{"name":"foo", "schema": {"type":"object", "properties":{"bar":{"type": "int"}}, "required": ["bar"]}, "required":true}`.
     */
    'flatten_deep_query_parameters' => true,

    'middleware' => [
        'web',
        RestrictedDocsAccess::class,
    ],

    'extensions' => [],
];
```

3. Ahora ya podemos acceder
```bash
php artisan serve
```
- http://127.0.0.1:8001/docs/api
- Ya podremos ver nuestros endpoints documentados