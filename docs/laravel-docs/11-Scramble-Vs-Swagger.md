# Scramble vs Swagger en Laravel

Scramble y Swagger pueden coexistir en un mismo proyecto, pero **no son iguales**, **no funcionan igual** y **no sirven para lo mismo**.  
Esta tabla resume sus diferencias reales.

---

## 🧩 Comparativa general

| Característica | Scramble | Swagger (L5‑Swagger + swagger‑php) |
|----------------|----------|------------------------------------|
| Tipo de herramienta | Documentación automática | Documentación formal OpenAPI |
| Detección de rutas | Automática (lee el router de Laravel) | Manual (requiere atributos `#[OA\...]`) |
| Necesita anotaciones/atributos | ❌ No | ✔ Sí |
| Genera JSON OpenAPI | ❌ No | ✔ Sí (`api-docs.json`) |
| Nivel de detalle | Básico | Completo (requestBody, responses, modelos, seguridad…) |
| Ideal para | Desarrollo, debugging | Documentación profesional, clientes, SDKs |
| Velocidad | Muy rápido | Depende del análisis OpenAPI |
| Configuración | Casi nula | Requiere setup |
| UI | Moderna, limpia | Swagger UI estándar |
| Exportación | ❌ No | ✔ Sí (OpenAPI 3.1) |
| **Probar endpoints (Try it out)** | ❌ **NO** | ✔ **SÍ** |

---

# 🔥 Diferencia clave (RECALCADA)

## 🟥 Scramble **NO permite probar APIs**
- No tiene botón **Try it out**
- No ejecuta peticiones reales
- No envía JSON, headers ni cookies
- No sirve para testear autenticación

**Scramble = documentación visual estática.**

---

## 🟩 Swagger **SÍ permite probar APIs**
Swagger UI incluye un cliente HTTP integrado:

- ✔ Botón **Try it out**
- ✔ Enviar peticiones reales
- ✔ Probar autenticación (JWT, Bearer, cookies…)
- ✔ Ver respuestas reales del servidor
- ✔ Enviar body, headers y parámetros

**Swagger = documentación + cliente de pruebas interactivo.**

---

## 🟦 Scramble: autodocumentación basada en rutas

Scramble:

- Lee automáticamente `routes/api.php`
- Detecta controladores y métodos sin anotaciones
- No requiere atributos ni comentarios
- No genera OpenAPI
- Es perfecto para ver rápidamente qué endpoints existen

**Scramble documenta lo que Laravel TIENE.**

---

## 🟩 Swagger: documentación formal basada en atributos

Swagger:

- Requiere atributos PHP (`#[OA\...]`)
- No autodetecta rutas nuevas
- Genera documentación OpenAPI 3.1
- Permite definir modelos, ejemplos, seguridad, errores, etc.
- Es el estándar para APIs profesionales

**Swagger documenta lo que TÚ DEFINES.**

---

## 🧪 Ejemplo práctico para ver la diferencia

1. Crea una ruta nueva:

```php
Route::get('/ping', fn() => ['pong' => true]);

```
2. No la documentes con atributos.

Resultado:
Scramble: mostrará /api/ping
Swagger: NO mostrará /api/ping

### 🟧 Convivencia en el mismo proyecto

Sí, pueden convivir sin problema:

- Scramble → /docs
- Swagger → /api/documentation

Solo asegúrate de:

- No mezclar anotaciones antiguas con atributos
- No esperar que Scramble lea atributos
- No esperar que Swagger autodetecte rutas

## 🟢 Resumen final

- Scramble = autodiscovery
- Swagger = OpenAPI formal
- Scramble documenta rutas reales
- Swagger documenta lo que tú marcas
- No son iguales, no sirven para lo mismo