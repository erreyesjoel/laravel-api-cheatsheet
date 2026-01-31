# Como mostrar datos de una API GET
### Ejemplo con Header.tsx, para mostrar el email o nombre del usuario autenticado

1. Importar el servicio de usuario
2. Usar el hook `useEffect` para obtener el usuario autenticado nada mas renderizar el componente
3. Usar el hook `useState` para guardar el usuario autenticado
4. Mostrar el usuario autenticado en el header

```tsx
import "./Header.scss";
import { useEffect } from "react";
import { UserService } from "../../api/services/user.service";
import { useState } from 'react'


const Header = () => {
    const [user, setUser] = useState<any | null>(null);
    useEffect(() => {
        const fetchUser = async () => {
            const user = await UserService.getUser();
            setUser(user);
        };
        fetchUser();
    }, []);

    return (
        <header className="app-header">
            <div className="logo">Gestor Tareas</div>
            <nav className="nav-links">
                <a href="/">Inicio</a>
                <a href="/docs">Docs</a>
                {user && <span className="user-email">{user.email}</span>}
            </nav>
        </header>
    );
};

export default Header;
```

## ¿Cuándo usar Interfaces vs `any`?

En el ejemplo anterior usamos `useState<any | null>(null)`, pero esto **no es una buena práctica** en aplicaciones reales.

### ❌ Cuándo usar `any` (Evitar si es posible)
- **Solo durante prototipado rápido:** Cuando aún no conoces la estructura final de la API y solo quieres ver si funciona.
- **Riesgos:** 
    1. Pierdes el autocompletado.
    2. TypeScript no te avisará si escribes mal una propiedad.
    3. **Si mañana cambias en el backend `email` por `correo`, tu TypeScript no te dirá nada hasta que la app se rompa en el navegador del usuario final**.

```tsx
// ❌ Mala práctica en producción
const [user, setUser] = useState<any>(null);
// TypeScript permite esto aunque esté mal escrito:
console.log(user.nombre_que_no_existe); // Crash en runtime
```

### ✅ Cuándo usar Interfaces (Recomendado)
- **Siempre en código real:** Define la estructura exacta de tus datos.
- **Ventajas:** Autocompletado inteligente y detección de errores antes de ejecutar el código.

Primero defines la interfaz:
```tsx
// types/User.ts
export interface User {
    id: number;
    name: string;
    email: string;
    created_at: string;
}
```

Y luego la usas en el estado:
```tsx
// Header.tsx
import { User } from '../../types/User';

const [user, setUser] = useState<User | null>(null);

// ✅ Ahora TypeScript te ayuda:
// user.email (Autocompletado funciona)
// user.nonExistent (Error: Property does not exist on type 'User')
```

## EJEMPLO FINAL CON Header.tsx
```tsx
import "./Header.scss";
import { useEffect, useState } from "react";
import { UserService } from "../../api/services/user.service";
import type { User } from "../../types/User";

const Header = () => {
    const [user, setUser] = useState<User | null>(null);
    useEffect(() => {
        const fetchUser = async () => {
            const user = await UserService.getUser();
            setUser(user);
        };
        fetchUser();
    }, []);

    return (
        <header className="app-header">
            <div className="logo">Gestor Tareas</div>
            <nav className="nav-links">
                <a href="/">Inicio</a>
                <a href="/docs">Docs</a>
                {user && <span className="user-email">{user.email}</span>}
            </nav>
        </header>
    );
};

export default Header;
```
