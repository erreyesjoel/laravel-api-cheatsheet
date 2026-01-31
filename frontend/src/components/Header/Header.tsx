import "./Header.scss";

const Header = () => {
    return (
        <header className="app-header">
            <div className="logo">Gestor Tareas</div>

            <nav className="nav-links">
                <a href="/">Inicio</a>
                <a href="/dashboard">Dashboard</a>
                <a href="/docs">Docs</a>
            </nav>
        </header>
    );
};

export default Header;
