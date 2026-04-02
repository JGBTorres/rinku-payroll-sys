export interface Rol {
    id: number;
    nombre: string;
    salario_base: string;
    bono_por_hora: string;
}

export interface Empleado {
    uuid?: string;
    id?: number;
    numero_empleado: string;
    nombre: string;
    rol_id: number | string;
    es_interno: number;
    fecha_ingreso: string;
    activo?: boolean;
    rol?: Rol;
}

export interface Movimiento {
    id?: number;
    uuid?: string;
    empleado_id?: number;
    fecha: string;
    horas_trabajadas: number;
    entregas: number;
    rol_aplicado_id: number | null;
    empleado?: Partial<Empleado>;
}

export interface NominaMensual {
    id?: number;
    empleado_id: number;
    mes: number;
    anio: number;
    sueldo_base: number;
    bono_horas: number;
    bono_entregas: number;
    vales_despensa: number;
    sueldo_bruto: number;
    sueldo_neto: number;
    retenciones: number;
    empleado?: Empleado;
}
