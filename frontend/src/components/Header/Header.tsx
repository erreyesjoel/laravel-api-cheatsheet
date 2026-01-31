import "./Header.scss";
import { useEffect } from "react";
import { UserService } from "../../api/services/user.service";

const Header = () => {
    useEffect(() => {
        const fetchUser = async () => {
            const user = await UserService.getUser();
            console.log(user);
        };
        fetchUser();
    }, []);

    return (
        <header className="app-header">
            <div className="logo">Gestor Tareas</div>

            <nav className="nav-links">
                <a href="/">Inicio</a>
                <a href="/docs">Docs</a>
            </nav>
        </header>
    );
};

export default Header;
