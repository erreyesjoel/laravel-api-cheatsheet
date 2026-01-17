# Como definir rutas en React
1. Instalar react-router-dom
```bash
npm install react-router-dom
```
- Salida del terminal
```bash
joel-erreyes:~/docsjoel/proyectos personales/laravel-api-cheatsheet/frontend$ npm install react-router-dom

added 4 packages, and audited 196 packages in 5s

52 packages are looking for funding
  run `npm fund` for details

found 0 vulnerabilities
```
2. Crear una estructura de carpetas, a mi esta me parece muy clara y entendible
- **src/router/Router.tsx** -> Aqui definiremos TODAS las rutas
- Ahora en **src/pages** creamos dashboard, es lo que queremos por ahora
```bash
joel-erreyes:~/docsjoel/proyectos personales/laravel-api-cheatsheet/frontend/src/pages$ mkdir Dashboard
joel-erreyes:~/docsjoel/proyectos personales/laravel-api-cheatsheet/frontend/src/pages$ cd Dashboard/
joel-erreyes:~/docsjoel/proyectos personales/laravel-api-cheatsheet/frontend/src/pages/Dashboard$ ls
Dashboard.tsx
joel-erreyes:~/docsjoel/proyectos personales/laravel-api-cheatsheet/frontend/src/pages/Dashboard$ 
```

3. Ahora si, podemos definir una ruta, ruta dashboard en nuestro caso en Router.tsx
- Esto convierte tus .tsx en rutas.
- No hay magia. No hay archivos especiales. Solo componentes.
- Routes, Route son componentes de react-router-dom
- Con <Routes></Routes> envolvemos todas las rutas y <Route></Route> define una ruta
**src/router/Router.tsx**
```tsx
import { Routes, Route } from "react-router-dom";
import Auth from "../pages/Auth/Auth";
import Dashboard from "../pages/Dashboard/Dashboard";

const AppRouter = () => {
    return (
        <Routes>
            <Route path="/" element={<Auth />} />
            <Route path="/dashboard" element={<Dashboard />} />
        </Routes>
    );
};

export default AppRouter;
```

4. Dashboard/Dashboard.tsx (de ejemplo por ahora)
```tsx
const Dashboard = () => {
    return (
        <h1>Dashboard</h1>
    );
}

export default Dashboard
```

5. En App.tsx, solo importamos el Router.tsx
```tsx
import AppRouter from "./router/Router";

const App = () => {
  return <AppRouter />;
};

export default App;
```
- Teniamos ahi Auth.tsx, pero ahora la hemos definido como /
- Arriba lo pone

6. main.tsx
- Routes y Route solo funcionan dentro de un BrowserRouter
- Asi que debemos importarlo en main.tsx, si no no funcionarán las rutas
```tsx
import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom'; // IMPORTANTE
import App from './App.tsx';
import './styles/_main.scss';

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <BrowserRouter>
      <App />
    </BrowserRouter>
  </StrictMode>
);
```
