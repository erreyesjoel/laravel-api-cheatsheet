# Como redirigir en React
1. Importar useNavigate
```tsx
import { useNavigate } from "react-router-dom";
```
2. Crear el navigate dentro del componente
```tsx
const navigate = useNavigate();
```
3. Usar el navigate para redirigir
- Ejemplo
```tsx
navigate("/dashboard");
```

## EJEMPLO COMPLETO EN Auth.tsx

1. Importar useNavigate
2. Crear el navigate dentro del componente
3. Usar el navigate para redirigir
- Sintaxis
```tsx
navigate("/dashboard");
```
- Auth.tsx completo
```tsx
import styles from './Auth.module.scss'
import { useState } from 'react'
import { AuthService } from '../../api/services/auth.service'
import { useNavigate } from 'react-router-dom'

const Auth = () => {
    const navigate = useNavigate()
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
                navigate("/dashboard") // redirigir a dashboard

            } catch (error) {
                console.error("Error en login:", error)
            }
        } else {
            // REGISTER
            try {
                const res = await AuthService.register({ email, password })
                console.log("Register response:", res)
                navigate("/dashboard") // redirigir a dashboard
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