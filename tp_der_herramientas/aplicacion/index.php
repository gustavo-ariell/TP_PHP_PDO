<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Préstamos de Herramientas</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PRÉSTAMOS DE HERRAMIENTAS</h1>
    <nav>
        <a href="index.php">[ Inicio ]</a>
        <a href="persona/listar.php">[ Personas ]</a>
        <a href="categoria/listar.php">[ Categorías ]</a>
        <a href="herramienta/listar.php">[ Herramientas ]</a>
        <a href="prestamo/listar.php">[ Préstamos ]</a>
        <a href="consultas/prestamos_activos.php">[ Consultas ]</a>
    </nav>
</header>

<main>

    <h2>Menú principal</h2>

    <h3>Altas</h3>
    <ul>
        <li><a href="persona/alta.php">Registrar persona</a></li>
        <li><a href="categoria/alta.php">Registrar categoría</a></li>
        <li><a href="herramienta/alta.php">Registrar herramienta</a></li>
        <li><a href="prestamo/alta.php">Generar préstamo</a></li>
    </ul>

    <h3>Listados y operaciones</h3>
    <ul>
        <li><a href="persona/listar.php">Listar y modificar personas</a></li>
        <li><a href="categoria/listar.php">Listar y eliminar categorías</a></li>
        <li><a href="herramienta/listar.php">Listar y modificar herramientas</a></li>
        <li><a href="prestamo/listar.php">Listar préstamos</a></li>
        <li><a href="prestamo/devolver.php">Registrar devolución</a></li>
    </ul>

    <h3>Consultas</h3>
    <ul>
        <li><a href="consultas/prestamos_activos.php">Préstamos activos</a></li>
        <li><a href="consultas/herramientas_disponibles.php">Herramientas disponibles</a></li>
        <li><a href="consultas/herramientas_pendientes.php">Herramientas pendientes de devolución</a></li>
    </ul>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Préstamos de Herramientas</p>
</footer>

</body>
</html>
