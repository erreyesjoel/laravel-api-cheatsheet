import { API_URL } from "../../environment-variables/environments";

// metodo para obtener el usuario autenticado
export const UserService = {
    getUser: async () => {
        const res = await fetch(`${API_URL}/user`, {
            method: "GET",
            credentials: "include",
        });
        return res.json();
    },
};
