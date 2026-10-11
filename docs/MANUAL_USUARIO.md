# Manual de usuario (prototipo académico)

## 1. Roles

- **Administrador:** puede ver y modificar inventario, registrar/editar vehículos, prestar/devolver, ver auditoría y dar de baja recursos.
- **Logística:** puede consultar y modificar inventario, registrar/editar vehículos y registrar préstamos/devoluciones; no accede a auditoría ni a bajas.
- **Voluntario:** solo consulta panel, inventario, préstamos y vehículos.

## 2. Inicio de sesión

Abre la aplicación local y escribe las credenciales demostrativas. Una vez dentro, aparece el panel con métricas y alertas. Para salir utiliza el botón **Salir**.

## 3. Crear, editar y dar de baja recursos

Desde **Inventario** elige **+ Nuevo recurso**. Completa código único, nombre, categoría, ubicación, estado, cantidad y mínimo. Guarda. Se muestra el registro en la tabla. Para modificarlo usa **Editar**. Solo el administrador puede ejecutar **Baja**, que conserva el historial, en lugar de borrar físicamente la fila.

## 4. Prestar y devolver

En **Asignaciones** selecciona **+ Registrar préstamo**. Elige un recurso y cantidad, y consigna el receptor (datos de prueba). Si el recurso está vencido, en mantenimiento o no hay unidades disponibles, el sistema rechaza la operación. En el listado usa **Devolver** para registrar el regreso de las unidades.

## 5. Vehículos

En **Unidades** crea o edita las fichas de vehículo con código, tipo, estado, kilometraje y próxima fecha de revisión. Este módulo **no** controla vehículos en tiempo real ni gestiona despachos.

## 6. Panel principal

Consulta recursos, préstamos activos y alertas. La alerta de stock aparece cuando la disponibilidad está en o debajo del mínimo. Las alertas de vencimiento consideran los próximos 30 días.

## 7. Uso responsable

No subir credenciales, datos médicos ni datos estratégicos o sensibles de una compañía de bomberos. Las capturas de clase deben usar el conjunto **DEMO**. El permiso institucional es imprescindible antes de acceder o cargar registros reales.
