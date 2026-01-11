# 📘 01 — Crear un Proyecto Laravel

Para crear un proyecto Laravel moderno (Laravel 12.x), necesitamos tener instaladas algunas herramientas básicas y luego usar uno de los dos métodos oficiales: **Composer** o el **Laravel Installer**.

---

## 🧩 Requisitos previos

Antes de crear un proyecto Laravel, asegúrate de tener instalado:

### ✔ PHP 8.x  
Laravel 12 requiere PHP 8.2 o superior.

Comprueba tu versión con:

```bash
php -v
```
### ✔ Composer
Laravel utiliza composer para gestionar dependencias
Comprueba si lo tienes instalado
```bash
composer -V
```

### 🚀 Crear un nuevo proyecto Laravel con Composer (método recomendado)
Este és el metodo más universal y el que hemos usado para crear nuestro proyecto
Esto hará lo siguiente:
- Descarga la última versión de Laravel
- Instala todas las dependencias
- Crea un proyecto completo dentro de la carpeta src/
```bash
composer create-project laravel/laravel src
```
**src és el nombre que le damos al proyecto, pero podemos poner el nombre que queramos**
**dentro de /src tendremos, modelos, controladores, migraciones, .gitignore automàtico...**

Después podemos entrar al proyecto y comprobar la version
```bash
cd src
php artisan --version
```

### 🚀 Crear un nuevo proyecto con Laravel Installer (opcional)
Si prefieres usar el comando laravel new, primero debes instalar el Laravel Installer globalmente:
```bash
composer global require laravel/installer
```
Luego asegúrate de añadir el directorio global de Composer al PATH:
```bash
export PATH="$HOME/.config/composer/vendor/bin:$PATH"
```
(Esto puede variar según tu sistema.)

Una vez instalado, puedes crear un proyecto así:
```bash
laravel new src
```
**src és el nombre que le damos al proyecto, pero podemos poner el nombre que queramos**
