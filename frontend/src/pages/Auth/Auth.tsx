const Auth = () => {
    return (
        <div className="auth-container">
            <div className="auth-carta">
                <h1>Iniciar sesion</h1>
                <form>
                    <div>
                        <label>Email</label>
                        <input type="email" id="email" placeholder="correo@ejemplo.com" />
                    </div>
                    <div>
                        <label>Contraseña</label>
                        <input type="password" id="password" placeholder="********" />
                    </div>
                    <button type="submit">Entrar</button>
                </form>
            </div>
        </div>
    )
}

export default Auth // importante para que pueda ser importado