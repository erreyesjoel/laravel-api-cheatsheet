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
3. Ahora he creado un directorio en src/environment-variables, ahi un environments.ts
```ts
// constante que contiene la url de la api, donde se ejecuta nuestro backend, donde estan las apis
export const API_URL = import.meta.env.VITE_API_URL;
console.log(API_URL);
```
4. Para probar que funciona, importamos la constante API_URL en el App.tsx, veremos en console la url del backend
```tsx
import { useState } from 'react'
import reactLogo from './assets/react.svg'
import viteLogo from '/vite.svg'
import './App.css'
import { API_URL } from './environment-variables/environments';

function App() {
  const [count, setCount] = useState(0)

  return (
    <>
      <div>
        <a href="https://vite.dev" target="_blank">
          <img src={viteLogo} className="logo" alt="Vite logo" />
        </a>
        <a href="https://react.dev" target="_blank">
          <img src={reactLogo} className="logo react" alt="React logo" />
        </a>
      </div>
      <h1>Vite + React</h1>
      <div className="card">
        <button onClick={() => setCount((count) => count + 1)}>
          count is {count}
        </button>
        <p>
          Edit <code>src/App.tsx</code> and save to test HMR
        </p>
      </div>
      <p className="read-the-docs">
        Click on the Vite and React logos to learn more
      </p>
    </>
  )
}

export default App
```
