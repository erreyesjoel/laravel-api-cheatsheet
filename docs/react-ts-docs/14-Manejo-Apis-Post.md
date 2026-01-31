# Manejo Apis Post
# Implementar Logout en React (con Laravel API)

Para cerrar sesión, necesitamos consumir el endpoint de logout de la API, limpiar el estado local y redirigir al usuario (o recargar la página).

## 1. El Servicio (`AuthService`)
Asegúrate de que tu servicio llama al endpoint `/logout` con POST y `credentials: "include"` para que envíe la cookie de sesión/token.

```ts
logout: async () => {
    const res = await fetch(`${API_URL}/logout`, {
        method: "POST",
        credentials: "include", 
    });
    return res.json();
},
```

## 2. El Componente (`Header.tsx`)
Implementamos la lógica en el botón.

### Lógica
```tsx
const handleLogout = async () => {
    // 1. Llamar a la API para invalidar token en servidor
    await AuthService.logout();
    
    // 2. Limpiar estado local
    setUser(null);
    
    // 3. Recargar o redirigir
    // window.location.reload() es útil para asegurar limpieza total
    window.location.reload(); 
};
```

### UI Condicional
Es buena práctica mostrar el botón de Login o Logout dependiendo del estado del usuario.

```tsx
<nav>
    <a href="/">Inicio</a>
    <a href="/docs">Docs</a>
    {user && (
        // Solo mostramos esto si el usuario está logueado
        <>
            <span className="user-email">{user.email}</span>
            <button onClick={handleLogout} className="logout-btn">
                Cerrar sesión
            </button>
        </>
    )}
</nav>
```

## 3. Estilos (`Header.scss`)
Diferencia visualmente las acciones.

```scss
// Botón Logout (Estilo Alerta/Danger)
.logout-btn {
    border: 1px solid #dba6a6;
    color: #d35e5e;
    background: transparent;
    cursor: pointer;
    // ...
    &:hover {
        background: #d35e5e;
        color: white;
    }
}
```
