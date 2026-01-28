import { useEffect, useState } from "react";
// useLocation para obtener la ruta actual
import { Navigate, useLocation } from "react-router-dom";

// ReactNode es SOLO el tipo de lo que va dentro de <PrivateRoute>...</PrivateRoute>
// Es decir: children puede ser cualquier cosa que React pueda renderizar (un componente, texto, etc.)
import type { ReactNode } from "react";

import { UserService } from "../api/services/user.service";

const PrivateRoute = ({ children }: { children: ReactNode }) => {
    // allowed = si el usuario está permitido o no
    // null = aún no sabemos (cargando)
    // true = logeado
    // false = NO logeado
    const [allowed, setAllowed] = useState<boolean | null>(null);

    const location = useLocation(); // creamos la variable location para obtener la ruta actual

    // nada mas renderizar el componente, comprobar si el usuario esta logeado
    useEffect(() => {
        const checkUser = async () => {
            try {
                const user = await UserService.getUser();

                // Si el backend devuelve un usuario válido -> está logeado
                if (user && !user.error) {
                    setAllowed(true); // true si está logeado
                } else {
                    // Si devuelve error o 401 -> no está logeado
                    setAllowed(false); // false si NO está logeado
                }
            } catch {
                // Si hay error de red -> tampoco está logeado
                setAllowed(false); // false si NO está logeado
            }
        };

        checkUser();
    }, []);

    const validateUser = () => {
        // allowed === null significa que aún no sabemos si está logeado
        // mostramos un "Cargando..." mientras esperamos la respuesta del backend
        if (allowed === null) return <p>Cargando...</p>;

        const isLogged = allowed === true; // true si está logeado
        const path = location.pathname; // con esto obtenemos la ruta actual

        switch (true) {
            // No logeado -> intenta entrar a dashboard
            // Si NO está logeado y quiere entrar a /dashboard, lo mandamos al login (/)
            case !isLogged && path === "/dashboard":
                return <Navigate to="/" replace />;

            // Logeado -> intenta entrar a login
            // Si está logeado y quiere entrar a /, lo mandamos al dashboard
            case isLogged && path === "/":
                return <Navigate to="/dashboard" replace />;

            // Cualquier otro caso -> render normal
            // Aquí simplemente mostramos el contenido que envuelve PrivateRoute
            // Ese contenido es "children"
            default:
                return <>{children}</>;
        }
    };

    return validateUser();
};

export default PrivateRoute;
