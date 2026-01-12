import styles from './Auth.module.scss'
import { useState } from 'react'

const Auth = () => {
    const [isRegister, setIsRegister] = useState(false)

    return (
        <div className={styles.authContainer}>
            <div className={styles.authCard}>
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
                            <input className={styles.inputsAuth} type="password" id="name" placeholder="Confirmar contraseña" />
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
