import clienteAxios from '../api/clienteAxios';

// Servicio para manejar las operaciones relacionadas con empleados
export const empleadoService = {
    buscar: (numero) => clienteAxios.get(`/empleados/numero/${numero}`),
    crear: (datos) => clienteAxios.post('/empleados', datos),
    actualizar: (uuid, datos) => clienteAxios.put(`/empleados/${uuid}`, datos),
    eliminar: (uuid) => clienteAxios.delete(`/empleados/${uuid}`),
    // Función para verificar si un número de empleado ya existe
    verificarDuplicado: (numero) => clienteAxios.get(`/empleados/verificar/${numero}`),
};
