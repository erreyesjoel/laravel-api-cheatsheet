# Fundamentos básicos
## 1. main.tsx
- main.tsx es el archivo principal de la aplicación
- Si en App.tsx por ejemplo, borramos el import de App.css, seguiremos viendo un css global.
- Que está importado en main.tsx, es index.css
- Lo quitamos si no lo usamos, asi no aplicará ese css global
- Asi quedaria main.tsx
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
## 2. Importacion de componentes
- Al final del archivo .tsx, importante tener
```tsx
export default [nombre del componente]
```
- Para que el componente pueda ser importado en otro archivo

**Ejemplo con Auth.tsx**
```tsx
<DEFAULTCOMPONENTE/>
```
- Lo importaremos en src/App.tsx
```tsx
import Auth from './pages/Auth/Auth'

const App = () => {
  return <Auth />
}

export default App
```
