# Relación con las diapositivas del curso (Semanas 1–7)

| Semana | Tema en diapositivas | Aplicación en SystemBomb | Archivo representativo |
|---|---|---|---|
| 1 | HTML, estructura y etiquetas | Formularios, tablas, navegación | `resources/views/` |
| 2 | CSS y presentación/front-end | Layout, responsive, estados, diseño | `public/css/systembomb.css` |
| 3 | JavaScript, DOM, eventos | Menú móvil, confirmación, demo local | `public/js/systembomb.js`, `demo/demo.js` |
| 4 | Frameworks, MVC | Laravel como framework; rutas, controladores, modelos, vistas | `routes/web.php`, `app/Http/Controllers/` |
| 5 | Capa de negocio en Spring Boot, inyección, transacciones, DTO | Se **adoptan los principios** de negocio y transacciones, pero se implementan en PHP/Laravel, no con `@Service` de Java | `app/Services/AssignmentService.php` |
| 6 | Interfaces, servicios, repositorios, principio de responsabilidad única | Interfaces y repositorios aislados; inyección por constructor | `app/Contracts/`, `app/Repositories/`, `app/Providers/` |
| 7 | Implementación Laravel con Service, Service Provider, Requests, Controlador | `ResourceService`, `AppServiceProvider`, `ResourceRequest`, controladores | `app/Services/`, `app/Providers/AppServiceProvider.php`, `app/Http/Requests/` |

**Nota:** la clase de semana 5 usa Spring Boot como ejemplo, mientras que semanas 6–7 muestran Laravel. Se eligió solo Laravel en el proyecto para evitar mezclar sintaxis de Java/Spring con PHP.

El código no afirma que **DTO formal** esté implementado en todos los módulos: para este MVP, los `FormRequest` entregan arreglos validados a las clases de servicio. Se puede añadir un DTO tipado si el profesor lo pide en una iteración posterior.
