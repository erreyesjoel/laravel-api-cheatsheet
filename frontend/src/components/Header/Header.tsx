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
