<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Pedidos — Rotisería</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PEDIDOS — ROTISERÍA</h1>
    <nav>
        <a href="index.php">[ Inicio ]</a>
        <a href="cliente/listar.php">[ Clientes ]</a>
        <a href="producto/listar.php">[ Productos ]</a>
        <a href="categoria/listar.php">[ Categorías ]</a>
        <a href="repartidor/listar.php">[ Repartidores ]</a>
        <a href="pedido/listar.php">[ Pedidos ]</a>
        <a href="consultas/pedidos_pendientes.php">[ Consultas ]</a>
    </nav>
</header>

<main>

    <h2>Menú principal</h2>

    <h3>Altas</h3>
    <ul>
        <li><a href="cliente/alta.php">Registrar cliente</a></li>
        <li><a href="producto/alta.php">Registrar producto</a></li>
        <li><a href="categoria/alta.php">Registrar categoría</a></li>
        <li><a href="repartidor/alta.php">Registrar repartidor</a></li>
        <li><a href="pedido/alta.php">Registrar pedido</a></li>
        <li><a href="pedido/agregar.php">Agregar productos al pedido</a></li>
    </ul>

    <h3>Listados y operaciones</h3>
    <ul>
        <li><a href="cliente/listar.php">Listar y modificar clientes</a></li>
        <li><a href="producto/listar.php">Listar y modificar productos</a></li>
        <li><a href="categoria/listar.php">Listar y modificar categorías</a></li>
        <li><a href="repartidor/listar.php">Listar y modificar repartidores</a></li>
        <li><a href="pedido/listar.php">Listar pedidos</a></li>
        <li><a href="pedido/editar.php">Modificar estado del pedido</a></li>
    </ul>

    <h3>Consultas</h3>
    <ul>
        <li><a href="consultas/pedidos_pendientes.php">Pedidos pendientes</a></li>
        <li><a href="consultas/pedidos_por_cliente.php">Pedidos por cliente</a></li>
        <li><a href="consultas/productos_vendidos.php">Productos vendidos</a></li>
    </ul>

</main>

<footer>
    <p>Trabajo Práctico — Sistema de Gestión de Pedidos para Rotisería</p>
</footer>

</body>
</html>