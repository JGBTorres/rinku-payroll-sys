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
    API->>DB: Consultar datos del empleado
    DB-->>API: Retorna información del empleado

    API->>DB: Consultar movimientos del periodo
    DB-->>API: Retorna horas, entregas y rol aplicado

    Note right of API: Procesamiento
    Note over API: Se suman horas y entregas
    Note over API: Se calcula sueldo base
    Note over API: Se calculan bonos según rol aplicado
    Note over API: Se calcula sueldo bruto
    Note over API: Se aplican ISR y vales

    API-->>UI: Retorna resultados del cálculo
    UI-->>Usuario: Muestra desglose de nómina
