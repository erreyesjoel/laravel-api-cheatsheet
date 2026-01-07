### Base de datos con docker, conexion a Laravel
1. Crear el docker-compose.yml, yo no he querido mapear puertos de mysql 3306, porque en mi máquina tengo demasiados
```yml
version: "3.9"

services:
  mysql:
    image: mysql:8.0
    container_name: cheatsheet_laravel_bbdd_mysql
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: laravel
      MYSQL_USER: laravel
      MYSQL_PASSWORD: laravel
    volumes:
      - mysql_data:/var/lib/mysql
    networks:
      - laravel

networks:
  laravel:

volumes:
  mysql_data:
```
- Después de eso, levantar el contenedor
```bash
docker compose up -d
```
- Salida del terminal
```bash
joel-erreyes:~/docsjoel/proyectos personales/laravel-api-cheatsheet$ docker compose up -d
WARN[0000] /home/joel-erreyes/docsjoel/proyectos personales/laravel-api-cheatsheet/docker-compose.yml: the attribute `version` is obsolete, it will be ignored, please remove it to avoid potential confusion 
[+] Running 12/12
 ✔ mysql Pulled                                                                                                                                                                        19.7s 
[+] Running 3/3
 ✔ Network laravel-api-cheatsheet_laravel      Created                                                                                                                                  0.1s 
 ✔ Volume "laravel-api-cheatsheet_mysql_data"  Created                                                                                                                                  0.0s 
 ✔ Container cheatsheet_laravel_bbdd_mysql     Started
 ```

2. Conexión con el fichero .env

- Como no mapeamos puertos, MySQL no está accesible desde nuestra máquina usando -> 127.0.0.1:3306
Entonces Laravel no puede usar nuestro host como DB_HOST.
En su lugar, Laravel debe conectarse directamente a la IP interna del contenedor, porque:
El contenedor sí expone el puerto 3306 dentro de la red Docker
Nuestro host sí puede acceder a esa IP interna (mientras usemos la red bridge por defecto)
No necesitas puertos mapeados
Por eso el .env usa:
```.env
DB_CONNECTION=mysql
DB_HOST=172.26.0.2
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel
```
### 🟩 Cómo obtener la IP del contenedor MySQL
```bash
docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' cheatsheet_laravel_bbdd_mysql
```
- Salida del terminal
```bash
joel-erreyes:~/docsjoel/proyectos personales/laravel-api-cheatsheet/src$ docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' cheatsheet_laravel_bbdd_mysql
172.26.0.2
```
3. Ejecutar migraciones, si se ejecutan significa que la conexión és exitosa
```bash
php artisan migrate
```
- Salida del terminal
```bash
joel-erreyes:~/docsjoel/proyectos personales/laravel-api-cheatsheet/src$ php artisan migrate
PHP Warning:  PHP Startup: Unable to load dynamic library 'pdo_mysql' (tried: /usr/lib/php/20220829/pdo_mysql (/usr/lib/php/20220829/pdo_mysql: cannot open shared object file: No such file or directory), /usr/lib/php/20220829/pdo_mysql.so (/usr/lib/php/20220829/pdo_mysql.so: undefined symbol: pdo_parse_params)) in Unknown on line 0

   INFO  Preparing database.  

  Creating migration table ............................................................................................................ 28.46ms DONE

   INFO  Running migrations.  

  0001_01_01_000000_create_users_table ............................................................................................... 102.75ms DONE
  0001_01_01_000001_create_cache_table ................................................................................................ 67.77ms DONE
  0001_01_01_000002_create_jobs_table ................................................................................................ 110.44ms DONE
```

**NOTA IMPORTANTE SOBRE LA IP DINAMICA QUE ESTAMOS USANDO DE DOCKER**
- Si borramos el contenedor o la red de Docker (por ejemplo usando docker compose down -v, docker rm, o docker network rm)
- Docker asignará una nueva IP interna al contenedor MySQL.
**En ese caso, tendremos que volver a obtener la IP con docker inspect y actualizar el valor de DB_HOST en el .env.**
**Mientras no borres la red, la IP se mantiene estable y no hace falta cambiar nada**