# Hook useState
### Para que sirve el hook useState?
- Para guardar y manejar estados dentro de un componente de React
## 🟦 ¿Qué hace useState?
1. Guarda un valor
2. Te da una función para actualizarlo
3. Cuando se actualiza, react vuelve a renderizzar el componente con el nuevo valor
Ejemplo:
```tsx
const [isRegister, setIsRegister] = useState(false)
```
Significa:
- `isRegister` es el valor actual(false al inicio)
- `setIsRegister` es la función para actualizar el valor
Cuando haces:
```tsx
setIsRegister(true)
```
- React vuelve a renderizar el componente con el nuevo valor

## Implementado en Auth.tsx
- Para manejar estado si es login o registro
```tsx
import styles from './Auth.module.scss'
import { useState } from 'react'

const Auth = () => {
    const [isRegister, setIsRegister] = useState(false)

    return (
        <div className={styles.authContainer}>
            <div className={styles.authCard}>
                {/* Si no es registro, es login y mostramos h1 Iniciar sesion 
                Si es registro, mostramos h1 Crear cuenta */}
                <h1>{isRegister ? "Crear cuenta" : "Iniciar sesion"}</h1>
                <form className={styles.formAuth}>
                    {/* Email */}
                    <div>
                        <input className={styles.inputsAuth} type="email" id="email" placeholder="correo@ejemplo.com" />
                    </div>
                    {/* Password */}
                    <div>
                        <input className={styles.inputsAuth} type="password" id="password" placeholder="********" />
                    </div>

                    {/* Confirmar contraseña solo si es registro*/}
                    {isRegister && (
                        <div>
                            <input className={styles.inputsAuth} type="text" id="name" placeholder="Confirmar contraseña" />
                        </div>
                    )}
                    <button type="submit">{isRegister ? "Registrarse" : "Entrar"}</button>
                    {/* Cambiar entre login y registro */}
                    <p>
                        {isRegister ? (
                            <>
                                ¿Ya tienes cuenta?{" "}
                                {/* Si es registro, mostramos a Inicia sesión
                                por eso setIsRegister pasa a ser false */}
                                <a onClick={() => setIsRegister(false)}>
                                    Inicia sesión
                                </a>
                            </>
                        ) : (
                            <>
                                ¿No tienes cuenta?{" "}
                                {/* Si es login, mostramos a Regístrate */}
                                {/* por eso setIsRegister pasa a ser true, porque el valor cambia a registro */}
                                <a onClick={() => setIsRegister(true)}>
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
