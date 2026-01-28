import { Routes, Route } from "react-router-dom";
import Auth from "../pages/Auth/Auth";
import Dashboard from "../pages/Dashboard/Dashboard";
import PrivateRoute from "./PrivateRoute";

const AppRouter = () => {
    return (
        <Routes>
            <Route path="/" element={<PrivateRoute><Auth /></PrivateRoute>} />
            <Route path="/dashboard" element={<PrivateRoute><Dashboard /></PrivateRoute>} />
        </Routes>
    );
};

export default AppRouter;
