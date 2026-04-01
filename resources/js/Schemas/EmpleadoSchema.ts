import { z } from "zod";


// Esquema de validación para el formulario de empleado
export const empleadoSchema = z.object({
    numero_empleado: z.string().min(1, "El número de empleado es obligatorio"),
    nombre: z.string().min(10, "El nombre debe tener al menos 10 caracteres"),
    rol_id: z.coerce.number().min(1, "Selecciona un rol válido"),
    es_interno: z.coerce.number(),
    fecha_ingreso: z.string().optional(),
});
