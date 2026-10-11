# Plan de pruebas funcionales (ejecutar en el proyecto Laravel)

| ID | Caso | Acción | Resultado esperado |
|---|---|---|---|
| P01 | Acceso restringido | Abrir /panel sin sesión | Redirige a login |
| P02 | Acceso válido | Iniciar sesión con usuario demo | Muestra dashboard |
| P03 | CRUD inventario | Crear EPP-99, buscarlo, editarlo y marcar baja | Datos y estado persistidos |
| P04 | Permisos | Entrar como voluntario e intentar POST /recursos | Respuesta 403 |
| P05 | Stock insuficiente | Intentar prestar 999 cascos | Error de validación y no se guarda |
| P06 | Registrar devolución | Prestar 1 casco y devolver | Préstamo pasa a devuelto; disponibilidad se restaura |
| P07 | Validaciones | Intentar duplicar código EPP-001 | Error de unicidad |
| P08 | Seguridad | Escribir etiquetas HTML en notas y mostrarlas en vistas | No ejecuta scripts; aparece texto escapado |
| P09 | Responsive | Abrir panel en 375 px de ancho | Menú compacto y tablas con desplazamiento |
| P10 | Auditoría | Crear recurso como admin, visitar auditoría | Aparece evento de creación |

**Estado:** matriz para el equipo. Las pruebas PHP automatizadas no se ejecutaron en el entorno de elaboración por ausencia de Composer y de `pdo_sqlite`. La vista previa HTML/JS sí se probó con un navegador automatizado usando almacenamiento simulado, y superó alta de inventario, préstamo y devolución.
