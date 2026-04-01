

// Interfaz para representar un rol
export interface Rol {
    id: number;
    nombre: string;
    salario_base: string;
    bono_por_hora: string;
}


// Interfaz para representar un empleado
export interface Empleado {
    uuid?: string;
    numero_empleado: string;
    nombre: string;
    rol_id: number | string;
    es_interno: number;
    fecha_ingreso?: string;
    rol?: Rol;
    activo?: boolean;
}

// Interfaz para representar la respuesta de la API al obtener un empleado
export interface ApiResponse<T> {
    exito: boolean;
    mensaje: string;
    datos: T;
}
