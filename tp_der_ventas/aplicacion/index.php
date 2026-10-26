<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Ventas de Librería</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE VENTAS DE LIBRERÍA</h1>
    <nav>
        <a href="index.php">[ Inicio ]</a>
        <a href="producto/listar.php">[ Productos ]</a>
        <a href="cliente/listar.php">[ Clientes ]</a>
        <a href="vendedor/listar.php">[ Vendedores ]</a>
        <a href="venta/listar.php">[ Ventas ]</a>
        <a href="consultas/productos_vendidos.php">[ Consultas ]</a>
    </nav>
</header>

<main>

    <h2>Menú principal</h2>

    <h3>Altas</h3>
    <ul>
        <li><a href="producto/alta.php">Registrar producto</a></li>
        <li><a href="cliente/alta.php">Registrar cliente</a></li>
        <li><a href="vendedor/alta.php">Registrar vendedor</a></li>
        <li><a href="venta/alta.php">Generar venta</a></li>
    </ul>

    <h3>Listados y operaciones</h3>
    <ul>
        <li><a href="producto/listar.php">Listar y modificar productos</a></li>
        <li><a href="cliente/listar.php">Listar y modificar clientes</a></li>
        <li><a href="vendedor/listar.php">Listar y modificar vendedores</a></li>
        <li><a href="venta/listar.php">Listar ventas</a></li>
        <li><a href="venta/detalle.php">Agregar productos a una venta</a></li>
    </ul>

    <h3>Consultas</h3>
    <ul>
        <li><a href="consultas/productos_vendidos.php">Productos vendidos</a></li>
        <li><a href="consultas/total_por_venta.php">Total de cada venta</a></li>
        <li><a href="consultas/vendedor_responsable.php">Vendedor responsable</a></li>
    </ul>

</main>

<footer>
    <p>Trabajo Práctico — Sistema de Ventas de Librería</p>
</footer>

</body>
</html>