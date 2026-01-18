# Instalación limpia de L5‑Swagger 10 (OpenAPI 3.1)

## 1. Instalar L5‑Swagger 10

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
