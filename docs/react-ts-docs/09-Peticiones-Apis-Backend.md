# Debemos ser ordenados y claros para hacer nuestras peticiones a las apis de backend.
## Ejemplo de como lo estoy haciendo por ahora con una api de autenticacion (login por ahora)
1. En nuestro archivo .env del frontend, debemos crear una variable de entorno que contenga la url de la api de backend.
```env
VITE_API_URL=http://127.0.0.1:8001/api
```
2. Crear un archivo .ts donde guardar esa variable de entorno
- En nuestro caso src/environment-variables/environments.ts
```ts
// constante que contiene la url de la api, donde se ejecuta nuestro backend, donde estan las apis
export const API_URL = import.meta.env.VITE_API_URL;
console.log(API_URL); // SOLO PARA PROBAR EN DESARROLLO
```

3. Crear un archivo .ts, por ejemplo api.ts -> src/api/api.ts
- Donde definimos los endpoints, get, post, delete...
- Importamos la constante API_URL
- Aqui no usamos credentials include porque NO en todas necesitamos compartir cookies
```ts
import { API_URL } from "../environment-variables/environments";

export const api = {
    get: async (endpoint: string) => {
        const res = await fetch(`${API_URL}${endpoint}`, {
            method: "GET",
        });
        return res.json();
    },

    post: async (endpoint: string, body?: any) => {
        const res = await fetch(`${API_URL}${endpoint}`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(body),
        });
        return res.json();
    },

    delete: async (endpoint: string) => {
        const res = await fetch(`${API_URL}${endpoint}`, {
            method: "DELETE",
        });
        return res.json();
    },
};
```
4. Creamos dentro de src/api/services/ un archivo .ts, por ejemplo auth.service.ts
- Donde definimos los metodos de autenticacion (o cualquier metodo dependiendo de la api o lo que que sea que queramos usar)
- auth.service.ts
```ts
import { API_URL } from "../../environment-variables/environments";

interface Auth {
    email: string;
    password: string;
}

export const AuthService = {
    login: async (auth: Auth) => {
        console.log("Intentando login con email:", auth.email);
        const res = await fetch(`${API_URL}/login`, {
            method: "POST",
            credentials: "include", // para las cookies, si no, no se comparten
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(auth),
        });

        return res.json();
    },

    register: async (auth: Auth) => {
        const res = await fetch(`${API_URL}/register`, {
            method: "POST",
            credentials: "include", // para las cookies, si no, no se comparten
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(auth),
        });

        return res.json();
    },

    logout: async () => {
        const res = await fetch(`${API_URL}/logout`, {
            method: "POST",
            credentials: "include", // para las cookies, si no, no se comparten
        });

        return res.json();
    },
};
```

5. Ahora, "unirlo" al .tsx (Auth.tsx en nuestro caso)
```tsx
import styles from './Auth.module.scss'
import { useState } from 'react'
import { AuthService } from '../../api/services/auth.service'

const Auth = () => {
    const [isRegister, setIsRegister] = useState(false)

    // Estados para email y password
    const [email, setEmail] = useState("")
    const [password, setPassword] = useState("")

    // Manejar submit del formulario
    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault() // evitar recarga

        if (!isRegister) {
            // LOGIN
            try {
                const res = await AuthService.login({ email, password })
                console.log("Login response:", res)
            } catch (error) {
                console.error("Error en login:", error)
            }
        } else {
            // REGISTER
            try {
                const res = await AuthService.register({ email, password })
                console.log("Register response:", res)
            } catch (error) {
                console.error("Error en registro:", error)
            }
        }
    }

    return (
        <div className={styles.authContainer}>
            <div className={styles.authCard}>
                <h1>{isRegister ? "Crear cuenta" : "Iniciar sesion"}</h1>

                {/* Formulario */}
                <form className={styles.formAuth} onSubmit={handleSubmit}>

                    {/* Email */}
                    <div>
                        <input
                            className={styles.inputsAuth}
                            type="email"
                            id="email"
                            placeholder="correo@ejemplo.com"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                        />
                    </div>

                    {/* Password */}
                    <div>
                        <input
                            className={styles.inputsAuth}
                            type="password"
                            id="password"
                            placeholder="********"
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                        />
                    </div>

                    {/* Confirmar contraseña solo si es registro*/}
                    {isRegister && (
                        <div>
                            <input
                                className={styles.inputsAuth}
                                type="password"
                                id="name"
                                placeholder="Confirmar contraseña"
                            />
                        </div>
                    )}

                    {/* Botón con clase */}
                    <button className={styles.btnAuth} type="submit">
                        {isRegister ? "Registrarse" : "Entrar"}
                    </button>

                    {/* Cambiar entre login y registro */}
                    <p className={styles.textAuth}>
                        {isRegister ? (
                            <>
                                ¿Ya tienes cuenta?{" "}
                                {/* Si es registro, mostramos a Inicia sesión */}
                                <a className={styles.linkAuth} onClick={() => setIsRegister(false)}>
                                    Inicia sesión
                                </a>
                            </>
                        ) : (
                            <>
                                ¿No tienes cuenta?{" "}
                                {/* Si es login, mostramos a Regístrate */}
                                <a className={styles.linkAuth} onClick={() => setIsRegister(true)}>
                                    Regístrate
                                </a>
                            </>
                        )}
                    </p>
                </form>
            </div>
        </div>
    )
}

export default Auth
```


