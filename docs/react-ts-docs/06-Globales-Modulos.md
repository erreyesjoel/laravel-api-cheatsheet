# Globales
1. En _main.scss importamos los ficheros como globales, variables, mixins, etc
```scss
@use 'global';
```
2. Importamos _main.scss en main.tsx
```tsx
import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import App from './App.tsx'
import './styles/_main.scss';

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <App />
  </StrictMode>,
)
```
**Los @use dependen de la ubicacion del archivo .scss**

# Modulos
- Un modulo como Auth.module.scss, no se importa en _main.scss
- Porque mezclar estilos globales y locales puede causar problemas de sobrecarga, encapsulamiento y mantenimiento
- Es decir, Auth.module.scss solo se importa en el archivo donde se usa, como Auth.tsx