import "./Header.scss";
import { useEffect, useState } from "react";
import { UserService } from "../../api/services/user.service";
import { AuthService } from "../../api/services/auth.service";
import type { User } from "../../types/User";

const Header = () => {
    const [user, setUser] = useState<User | null>(null);

    useEffect(() => {
        const fetchUser = async () => {
            try {
                const user = await UserService.getUser();
                setUser(user);
            } catch (error) {
                console.error("No user logged in or error feching user");
            }
        };
        fetchUser();
    }, []);

    const handleLogout = async () => {
        await AuthService.logout();
        setUser(null);
        window.location.reload(); // Recargar para limpiar todo el estado de la app
    };

    return (
        <header className="app-header">
            <div className="logo">Gestor Tareas</div>
            <nav className="nav-links">
                <a href="/">Inicio</a>
                <a href="/docs">Docs</a>
                {user && (
                    <>
                        <span className="user-email">{user.email}</span>
                        <button onClick={handleLogout} className="logout-btn">
                            Cerrar sesión
                        </button>
                    </>
                )}
            </nav>
        </header>
    );
};

export default Header;
