# Punto B: Diagrama de Secuencia - Proceso de Cálculo

Este diagrama describe el flujo de interacción entre los componentes del sistema para realizar el cálculo del sueldo mensual, cumpliendo estrictamente con las reglas de negocio de Rinku.

```mermaid
sequenceDiagram
    autonumber
    actor Usuario
    participant UI as Interfaz (React)
    participant API as Backend (Laravel)
    participant DB as Base de Datos (PostgreSQL)

    Usuario->>UI: Selecciona empleado y periodo (mes/año)
    UI->>API: Solicita cálculo de nómina

    Note right of API: Obtención de datos
    API->>DB: Consultar información del empleado
    DB-->>API: Retorna empleado con role_id

    API->>DB: Consultar movimientos del periodo
    DB-->>API: Retorna horas, entregas y rol_aplicado_id

    Note right of API: Obtención de parámetros de rol
    API->>DB: Consultar roles según rol_aplicado_id
    DB-->>API: Retorna salario_base y bono_por_hora

    Note right of API: Procesamiento
    Note over API: Se suman horas y entregas por empleado
    Note over API: Se calcula sueldo base = horas_total * salario_base
    Note over API: Se calculan bonos = horas_total * bono_por_hora
    Note over API: Se calcula pago por entregas = entregas * bono_por_entrega (según rol)
    Note over API: Se calcula sueldo bruto = sueldo_base + bonos + pago_entregas
    Note over API: Se aplican ISR y vales
    Note over API: Se genera registro en nominas_mensuales con todos los totales

    API-->>UI: Retorna resultados del cálculo con desglose completo
    UI-->>Usuario: Muestra desglose de nómina
