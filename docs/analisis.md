**Alanisis de Requeruimientos del software**
---------------------------------------
*Entradas (Data Input)
---------------------------------------

--Catalago de empleados 
Numero: Identificador único del empleado 
Nombre: Nombre completo.
Rol: Chofer , Cargador o Auxiliar. 
Tipo: Interno o Externo.



--Movimientos : 
Número de empleado: Para asociar la actividad.
Nombre / Rol / Tipo: Datos informativos del empleado seleccionado.
Fecha: Día del registro.
Cantidad de entregas: Número de entregas realizadas en la jornada.
Cubrió turno (Checkbox): Indicador de si el trabajador realizó una suplencia.
Tipo (de turno cubierto): Selección entre Interno o Externo para la suplencia.



---------------------------------------
*Logica de negocio (Procesos)
---------------------------------------

Sueldo Base: Se calcula sobre una jornada estándar de 8 horas diarias con un pago de $30.00 por hora.
Fórmula diaria: $30.00 x 8 = $240.00.
Pago por Entregas: $5.00 adicionales por cada entrega realizada.
Bonos por Rol (por hora extra al sueldo base ):
Chofer: $10.00/hora.
Cargador: $5.00/hora.
Auxiliar: $0.00/hora.
Regla de Suplencias: Si un Auxiliar cubre el turno de un Chofer o Cargador, se le debe asignar el bono por hora del puesto que está cubriendo durante esa jornada.

-Prestaciones y Retenciones :

Vales de Despensa: 4% calculado sobre el Sueldo Mensual Bruto.
Restricción: Únicamente aplica para empleados con tipo de contrato Interno. Los Externos NO perciben este beneficio.

Impuesto sobre la Renta (ISR):

Tasa Base: 9% de retención sobre el sueldo mensual.

Tasa de Excedente: Si el sueldo mensual bruto supera los $16,000.00, se aplica una retención adicional del 3% (totalizando un 12% de ISR).
