<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Hotel</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="index.php">[ Inicio ]</a>
        <a href="habitacion/listar.php">[ Habitaciones ]</a>
        <a href="huesped/listar.php">[ Huéspedes ]</a>
        <a href="reserva/listar.php">[ Reservas ]</a>
        <a href="pago/listar.php">[ Pagos ]</a>
        <a href="consultas/habitaciones.php">[ Consultas ]</a>
    </nav>
</header>

<main>

    <h2>Menú principal</h2>

    <h3>Altas</h3>
    <ul>
        <li><a href="habitacion/alta.php">Registrar habitación</a></li>
        <li><a href="huesped/alta.php">Registrar huésped</a></li>
        <li><a href="reserva/alta.php">Generar reserva</a></li>
        <li><a href="pago/alta.php">Registrar pago</a></li>
    </ul>

    <h3>Listados y operaciones</h3>
    <ul>
        <li><a href="habitacion/listar.php">Listar y modificar habitaciones</a></li>
        <li><a href="huesped/listar.php">Listar y modificar huéspedes</a></li>
        <li><a href="reserva/listar.php">Listar y modificar reservas</a></li>
        <li><a href="pago/listar.php">Listar y modificar pagos</a></li>
    </ul>

    <h3>Consultas</h3>
    <ul>
        <li><a href="consultas/habitaciones.php">Consultar habitaciones</a></li>
        <li><a href="consultas/huespedes_alojados.php">Huéspedes alojados</a></li>
        <li><a href="consultas/reservas_activas.php">Reservas activas</a></li>
        <li><a href="consultas/pagos_realizados.php">Pagos realizados</a></li>
    </ul>

</main>

<footer>
    <p>Trabajo Práctico — Sistema de Gestión de Hotel</p>
</footer>

</body>
</html>