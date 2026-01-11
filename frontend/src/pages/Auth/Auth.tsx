import styles from './Auth.module.scss'

const Auth = () => {
    return (
        <div className={styles.authContainer}>
            <div className={styles.authCard}>
                <h1>Iniciar sesion</h1>
                <form className={styles.formAuth}>
                    <div>
                        <input className={styles.inputsAuth} type="email" id="email" placeholder="correo@ejemplo.com" />
                    </div>
                    <div>
                        <input className={styles.inputsAuth} type="password" id="password" placeholder="********" />
                    </div>
                    <button type="submit">Entrar</button>
                    <p>¿No tienes cuenta? <a href="#">Registrate</a></p>
                </form>
            </div>
        </div>
    )
}

export default Auth
