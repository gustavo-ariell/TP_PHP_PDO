<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Taller Mecánico</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="index.php">[ Inicio ]</a>
        <a href="cliente/listar.php">[ Clientes ]</a>
        <a href="mecanico/listar.php">[ Mecánicos ]</a>
        <a href="vehiculo/listar.php">[ Vehículos ]</a>
        <a href="servicio/listar.php">[ Servicios ]</a>
        <a href="reparacion/listar.php">[ Reparaciones ]</a>
        <a href="consultas/reparaciones_por_vehiculo.php">[ Consultas ]</a>
    </nav>
</header>

<main>

    <h2>Menú principal</h2>

    <h3>Altas</h3>
    <ul>
        <li><a href="cliente/alta.php">Registrar cliente</a></li>
        <li><a href="mecanico/alta.php">Registrar mecánico</a></li>
        <li><a href="tipo_vehiculo/alta.php">Registrar tipo de vehículo</a></li>
        <li><a href="vehiculo/alta.php">Registrar vehículo</a></li>
        <li><a href="servicio/alta.php">Registrar servicio</a></li>
        <li><a href="reparacion/alta.php">Registrar reparación</a></li>
        <li><a href="reparacion/asociar.php">Asociar servicios a reparación</a></li>
    </ul>

    <h3>Listados y operaciones</h3>
    <ul>
        <li><a href="cliente/listar.php">Listar y modificar clientes</a></li>
        <li><a href="mecanico/listar.php">Listar y modificar mecánicos</a></li>
        <li><a href="tipo_vehiculo/listar.php">Listar tipos de vehículo</a></li>
        <li><a href="vehiculo/listar.php">Listar y modificar vehículos</a></li>
        <li><a href="servicio/listar.php">Listar y modificar servicios</a></li>
        <li><a href="reparacion/listar.php">Listar y modificar reparaciones</a></li>
    </ul>

    <h3>Consultas</h3>
    <ul>
        <li><a href="consultas/reparaciones_por_vehiculo.php">Reparaciones por vehículo</a></li>
        <li><a href="consultas/servicios_por_reparacion.php">Servicios incluidos en cada reparación</a></li>
        <li><a href="consultas/vehiculos_por_cliente.php">Vehículos por cliente</a></li>
    </ul>

</main>

<footer>
    <p>Trabajo Práctico — Sistema de Gestión de Taller Mecánico</p>
</footer>

</body>
</html>