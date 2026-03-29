Análisis de Requerimientos del Software
Entradas (Data Input)
Catálogo de empleados

Se tiene un registro de empleados con la siguiente información:

Número de empleado: identificador único
Nombre: nombre completo
Rol: puede ser Chofer, Cargador o Auxiliar
Tipo de empleado: puede ser Interno o Subcontratado
Movimientos

Los movimientos representan la actividad diaria de cada empleado:

Número de empleado: para identificar al trabajador
Fecha: día en que se realizó la actividad
Horas trabajadas: cantidad de horas laboradas en esa jornada
Cantidad de entregas: total de entregas realizadas
Rol aplicado: rol que desempeñó ese día (puede ser distinto al habitual en caso de suplencia)
Lógica de Negocio (Procesos)
Sueldo Base

El sueldo base se calcula en función de las horas trabajadas:

Sueldo Base = Horas trabajadas × 30.00

Pago por Entregas

Se agrega un pago adicional por cada entrega realizada:

Pago por entregas = Número de entregas × 5.00

Bonos por Rol

Dependiendo del rol desempeñado, se agrega un bono por hora:

Chofer: 10.00 por hora
Cargador: 5.00 por hora
Auxiliar: 0.00 por hora
Regla de Suplencias

Si un empleado cubre un rol diferente al suyo, el cálculo se hace con el rol que realmente desempeñó ese día, no con su rol original.

Impuesto sobre la Renta (ISR)
Se aplica una tasa base del 9% sobre el sueldo bruto mensual
Si el sueldo bruto supera los 16,000.00, se aplica una tasa del 12%
Vales de Despensa
Se calcula el 4% del sueldo bruto mensual
Solo aplica para empleados internos
No aplica para empleados subcontratados
Salidas (Output)

El sistema debe generar la siguiente información:

Sueldo base total
Total por entregas
Total de bonos
Sueldo bruto
ISR retenido
Vales de despensa
Sueldo neto final
