# Como implementar Sass en React con TypeScript
1. Instalar sass, en la carpeta frontend
```bash
npm install sass
```
2. Dentro de src/ crear una carpeta styles/ y dentro de ella crear un fichero _main.scss
3. Importar SASS en React
- En main.tsx importar el fichero _main.scss
```ts
import './styles/_main.scss';
```
Con eso (importando _main.scss en main.tsx), ya tenemos SASS funcionando en TODA LA APP