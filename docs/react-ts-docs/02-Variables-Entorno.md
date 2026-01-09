# Definición de variables de entorno
### Para que sirven?
- Sirven para no exponer informacion sensible directamente, como de un fichero .env, secret_key, tokens de google, contraseñas...
## Nuestro caso, principal -> Que React sepa donde se ejecuta nuestro backend, apis en este caso, el Laravel
1. Creamos un fichero .env en el directorio frontend (que es donde esta nuestro react con ts)
```bash
joel-erreyes:~/docsjoel/proyectos personales/laravel-api-cheatsheet/frontend$ ls -la .env
-rw-rw-r-- 1 joel-erreyes joel-erreyes 39 ene  9 20:14 .env
```
2. Después ahi le indicamos donde se ejecuta el backend
```.env
VITE_API_URL=http://127.0.0.1:8001/api
```
