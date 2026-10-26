<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comedor Universitario</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE COMEDOR UNIVERSITARIO</h1>
    <nav>
        <a href="index.php">[ Inicio ]</a>
        <a href="estudiante/listar.php">[ Estudiantes ]</a>
        <a href="plato/listar.php">[ Platos ]</a>
        <a href="menu/listar.php">[ Menús ]</a>
        <a href="reserva/listar.php">[ Reservas ]</a>
        <a href="consultas/reservas_por_fecha.php">[ Consultas ]</a>
    </nav>
</header>

<main>

    <h2>Menú principal</h2>

    <h3>Altas</h3>
    <ul>
        <li><a href="estudiante/alta.php">Registrar estudiante</a></li>
        <li><a href="plato/alta.php">Registrar plato</a></li>
        <li><a href="menu/alta.php">Registrar menú</a></li>
        <li><a href="menu/asociar.php">Asociar platos a menú</a></li>
        <li><a href="reserva/alta.php">Realizar reserva</a></li>
    </ul>

    <h3>Listados y operaciones</h3>
    <ul>
        <li><a href="estudiante/listar.php">Listar y modificar estudiantes</a></li>
        <li><a href="plato/listar.php">Listar y modificar platos</a></li>
        <li><a href="menu/listar.php">Listar y modificar menús</a></li>
        <li><a href="reserva/listar.php">Listar y modificar reservas</a></li>
    </ul>

    <h3>Consultas</h3>
    <ul>
        <li><a href="consultas/reservas_por_fecha.php">Reservas por fecha</a></li>
        <li><a href="consultas/estudiantes_con_reservas.php">Estudiantes con reservas</a></li>
        <li><a href="consultas/platos_por_menu.php">Platos incluidos en cada menú</a></li>
    </ul>

</main>

<footer>
    <p>Trabajo Práctico — Sistema de Comedor Universitario</p>
</footer>

</body>
</html>