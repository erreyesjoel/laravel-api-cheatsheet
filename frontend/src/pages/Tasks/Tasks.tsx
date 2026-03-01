import { useEffect } from "react";
import { tasksService } from "../../api/services/tasks.service";

const Tasks = () => {
    useEffect(() => {
        const tasksFetch = async () => {
            try {
                const tasks = await tasksService.getTasks();
                console.log("Tareas usuario", tasks);
            } catch (error) {
                console.log(error);
            }
        }
        tasksFetch();
    }, []);

    return (
        <h1>Tareas usuario</h1>
    );
}

export default Tasks