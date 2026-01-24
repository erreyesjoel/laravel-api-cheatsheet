import { API_URL } from "../../environment-variables/environments";

interface Auth {
    email: string;
    password: string;
}

export const AuthService = {
    login: async (auth: Auth) => {
        console.log("Intentando login con email:", auth.email);
        const res = await fetch(`${API_URL}/login`, {
            method: "POST",
            credentials: "include", // para las cookies, si no, no se comparten
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(auth),
        });

        return res.json();
    },

    register: async (auth: Auth) => {
        const res = await fetch(`${API_URL}/register`, {
            method: "POST",
            credentials: "include", // para las cookies, si no, no se comparten
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(auth),
        });

        return res.json();
    },

    logout: async () => {
        const res = await fetch(`${API_URL}/logout`, {
            method: "POST",
            credentials: "include", // para las cookies, si no, no se comparten
        });

        return res.json();
    },
};
