# TP_PHP_PDO

Trabajo práctico de la materia **Sistemas de Base de Datos**, a cargo del profesor **Fausto Garcete**, en la **Escuela Normal 10**, año **2026**.

Autores: Godoy y Mutuberría.

## ¿De qué trata?

Cada carpeta es un mini-sistema completo que parte de un **DER** (diagrama entidad-relación) y lo lleva a una aplicación web hecha con **PHP + PDO** sobre **MySQL/MariaDB**. Cada sistema incluye el ABM (altas, bajas y modificaciones) de sus entidades y un conjunto de consultas.

## Estructura de cada proyecto

```
tp_der_<tema>/
├── aplicacion/      Aplicación PHP (index.php, conexion.php, css/, consultas/ y una carpeta por entidad)
├── base_datos/      Dump .sql con la estructura y los datos de ejemplo
└── documentacion/   Carátula e informe del trabajo
```

## Proyectos

| Carpeta | Tema |
|---|---|
| `tp_der_biblioteca` | Biblioteca escolar: libros, autores, editoriales, estudiantes y préstamos |
| `tp_der_biblioteca_digital` | Biblioteca digital: libros, autores, categorías, usuarios y descargas |
| `tp_der_capacitacion` | Capacitación: cursos, docentes, estudiantes e inscripciones |
| `tp_der_clinica` | Clínica: médicos, especialidades, pacientes y turnos |
| `tp_der_comedor` | Comedor: menús, platos, estudiantes y reservas |
| `tp_der_eventos` | Eventos: eventos, tipos, expositores, asistentes e inscripciones |
| `tp_der_herramientas` | Préstamo de herramientas: herramientas, categorías, personas y préstamos |
| `tp_der_hotel` | Hotel: habitaciones, huéspedes, reservas y pagos |
| `tp_der_inventario` | Inventario: productos, categorías, proveedores y movimientos de stock |
| `tp_der_musica` | Escuela de música: cursos, instrumentos, docentes, estudiantes e inscripciones |
| `tp_der_olimpiadas` | Olimpiadas: disciplinas, estudiantes e inscripciones |
| `tp_der_revista` | Revista científica: artículos, autores, secciones, evaluadores y evaluaciones |
| `tp_der_rotiseria` | Rotisería: productos, categorías, clientes, pedidos y repartidores |
| `tp_der_taller` | Taller mecánico: clientes, vehículos, mecánicos, servicios y reparaciones |
| `tp_der_ventas` | Ventas: clientes, vendedores, productos y ventas |

## Cómo ejecutarlo

1. Crear la base de datos e importar el dump de `base_datos/` del proyecto elegido.
2. Ajustar usuario y contraseña en `aplicacion/conexion.php`.
3. Servir la carpeta `aplicacion/` con Apache o con `php -S localhost:8000`.
