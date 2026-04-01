import axios from 'axios';
import { Empleado, ApiResponse } from '../Types';

const api = axios.create({
    baseURL: '/api',
    headers: { 'Content-Type': 'application/json' }
});

export const empleadoService = {
    // Nuevo método para traer a todos los empleados a la tabla
    listar: () => {
        return api.get<ApiResponse<Empleado[]>>('/empleados');
    },

    buscar: (numero: string, checkOnly: boolean = false) => {
        const url = `/empleados/numero/${numero}${checkOnly ? '?check_only=1' : ''}`;
        return api.get<ApiResponse<Empleado>>(url);
    },

    crear: (datos: Empleado) =>
        api.post<ApiResponse<Empleado>>('/empleados', datos),

    actualizar: (uuid: string, datos: Partial<Empleado>) =>
        api.put<ApiResponse<Empleado>>(`/empleados/${uuid}`, datos),

    eliminar: (numero: string) =>
        api.delete<ApiResponse<null>>(`/empleados/${numero}`),
};
