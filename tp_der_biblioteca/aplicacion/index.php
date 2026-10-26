<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Biblioteca Escolar</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="index.php">[ Inicio ]</a>
        <a href="libro/listar.php">[ Libros ]</a>
        <a href="autor/listar.php">[ Autores ]</a>
        <a href="editorial/listar.php">[ Editoriales ]</a>
        <a href="estudiante/listar.php">[ Estudiantes ]</a>
        <a href="prestamo/listar.php">[ Préstamos ]</a>
        <a href="consultas/libros_disponibles.php">[ Consultas ]</a>
    </nav>
</header>

<main>

    <h2>Menú principal</h2>

    <h3>Altas</h3>
    <ul>
        <li><a href="libro/alta.php">Registrar libro</a></li>
        <li><a href="autor/alta.php">Registrar autor</a></li>
        <li><a href="editorial/alta.php">Registrar editorial</a></li>
        <li><a href="estudiante/alta.php">Registrar estudiante</a></li>
        <li><a href="prestamo/alta.php">Registrar préstamo</a></li>
    </ul>

    <h3>Listados y operaciones</h3>
    <ul>
        <li><a href="libro/listar.php">Listar y modificar libros</a></li>
        <li><a href="autor/listar.php">Listar y modificar autores</a></li>
        <li><a href="editorial/listar.php">Listar y modificar editoriales</a></li>
        <li><a href="estudiante/listar.php">Listar y modificar estudiantes</a></li>
        <li><a href="prestamo/listar.php">Listar préstamos</a></li>
        <li><a href="prestamo/devolucion.php">Registrar devoluciones</a></li>
    </ul>

    <h3>Consultas</h3>
    <ul>
        <li><a href="consultas/libros_disponibles.php">Libros disponibles</a></li>
        <li><a href="consultas/libros_prestados.php">Libros prestados</a></li>
        <li><a href="consultas/prestamos_por_estudiante.php">Préstamos por estudiante</a></li>
        <li><a href="consultas/libros_autores.php">Libros y autores (INNER JOIN)</a></li>
    </ul>

</main>

<footer>
    <p>Trabajo Práctico — Desarrollo de Prototipo Web con PHP, PDO y MySQL</p>
</footer>

</body>
</html>