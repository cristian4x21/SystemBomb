# Diseño técnico de SystemBomb

## Arquitectura MVC + Service Layer + Repository

```text
[ Navegador (Blade/CSS/JS) ]
          | HTTPS / HTTP local
          v
[ Laravel: rutas / web.php ]
          |
          v
[ Auth + FormRequest (validación/autorización) ]
          |
          v
[ Controller (orquesta petición/respuesta) ]
          |
          v
[ Service (reglas de negocio) ]
          |                       \
          v                        \ -> [AuditService]
[ Repository Interface / Eloquent]  \
          |                          -> [AuditLog]
          v
[ Modelos Eloquent + Migraciones ]
          |
          v
[ SQLite local (base relacional de prueba) ]
```

## Responsabilidad por capas

- Vista (HTML/Blade): representa datos; usa salida escapada `{{ ... }}`. Las vistas no realizan escrituras directas a la base de datos.
- Ruta: asigna HTTP GET/POST/PUT/PATCH/DELETE a controladores específicos; agrupa acceso bajo `auth`.
- FormRequest: valida tipos, límites y reglas del formulario, y comprueba permiso del usuario.
- Controller: recibe una petición, llama al servicio y retorna vista/redirect; evita concentrar reglas de negocio.
- Service: controla préstamos, cálculos de disponibilidad, cambios y baja lógica. `DB::transaction()` agrupa la operación; `lockForUpdate()` reduce carrera concurrente en bases de datos que lo soportan.
- Repository: `ResourceRepositoryInterface` + `EloquentResourceRepository` desacopla listado y persistencia de recursos.
- Modelo: relaciones e información de objetos para Eloquent.

## Flujo «registrar préstamo»

1. Usuario con rol logística/administrador inicia sesión.
2. Abre formulario Nueva Asignación (`GET /asignaciones/nueva`).
3. Envía POST con CSRF, recurso, receptor y cantidad.
4. `AssignmentRequest` verifica permisos, tipos y campos obligatorios.
5. `AssignmentController` invoca `AssignmentService::create`.
6. El servicio inicia una transacción, bloquea recurso, revisa estado/vencimiento/stock.
7. Si no hay capacidad, retorna error de validación (sin guardar).
8. Si hay capacidad, inserta asignación con referencia al usuario que la registró y log de auditoría.
9. Controller retorna lista de asignaciones y mensaje de confirmación.

### Reglas de negocio (MVP)

- Un recurso dado de baja o en mantenimiento no puede prestarse.
- No se presta un recurso con vencimiento anterior al instante actual.
- La cantidad asignada debe ser positiva y no exceder la disponibilidad calculada.
- El registro de la asignación no disminuye la cantidad original; la disponibilidad se deduce de préstamos activos. Al devolver, el sistema deja de descontarla.
- No se reduce cantidad total por debajo de la cantidad aún prestada.
- No se da de baja un recurso que tiene préstamos sin cerrar.
- Los datos de ejemplo no representan el inventario real.

## Modelo de datos mínimo

```text
users (id, name, email, password_hash, role)
   | 1:N
assignments (id, resource_id, user_id, recipient, quantity, assigned_at, returned_at)
   | N:1
resources (id, code, name, category, location, status, quantity, min_stock, expires_at)

vehicles (id, code, type, plate, status, mileage, next_maintenance_at)
audit_logs (id, user_id, action, model_type, model_id, details, created_at)
```

## Reglas de seguridad incluidas

- Sesión con autenticación Laravel y regeneración tras iniciar sesión; cierre invalida sesión.
- CSRF en todos los formularios POST, PUT, PATCH y DELETE.
- Salida HTML escapada por defecto por Blade.
- Persistencia con Query Builder/Eloquent (parámetros enlazados; evitar SQL construido con texto de usuario).
- FormRequest con `authorize()` según rol y comprobaciones en las acciones sensibles.
- Contraseña hasheada por Laravel; sin contraseñas en texto plano en base.
- Baja lógica de recursos, permitiendo conservar historial.

## Límites conocidos

- No hay recuperación de contraseña ni integración institucional.
- La regla de stock funciona sobre cantidad y préstamos, sin lote individual ni seriales.
- La tabla de vehículos registra la **próxima** revisión; historial de mantenimientos detallado es una fase futura.
- Algunas carreras simultáneas pueden depender del motor de DB; para un despliegue multiusuario real usar PostgreSQL/MySQL y pruebas de concurrencia.
- Es necesario realizar pruebas de acceso, validación y seguridad en Laravel instalado antes de implementarlo en una institución.
