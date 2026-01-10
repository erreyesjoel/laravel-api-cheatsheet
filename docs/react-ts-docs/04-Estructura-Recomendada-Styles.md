# Estructura recomendada para estilos en React
## 1. Carpeta styles/ → Estilos globales
- En la carpeta styles/ crear un fichero _main.scss
- En el fichero _main.scss importamos los .scss con @use
- En styles/ colocamos los ficheros de estilos globales
- Ejemplo
```bash
src/styles/
  _variables.scss
  _mixins.scss
  _reset.scss
  _globals.scss
  _main.scss
```
- En main.tsx importamos el fichero _main.scss, y ya tendremos todos los estilos cargados
```tsx
import './styles/_main.scss';
```

## 2. Módulos SASS → Estilos locales por componente/página
Para evitar colisiones de clases y mantener el código escalable, usamos CSS Modules con SASS
- Ejemplo, para **paginas** -> src/pages/NombrePagina/
```bash
src/pages/Login/
  Login.tsx
  Login.module.scss
```
- Ejemplo, para **componentes** -> src/components/NombreComponente/
```bash
src/components/Button/
  Button.tsx
  Button.module.scss
```
- O si es muy simple
```bash
src/components/Button.tsx
src/components/Button.module.scss
```
