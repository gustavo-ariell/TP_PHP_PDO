<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Inventario</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE INVENTARIO</h1>
    <nav>
        <a href="index.php">[ Inicio ]</a>
        <a href="producto/listar.php">[ Productos ]</a>
        <a href="categoria/listar.php">[ Categorías ]</a>
        <a href="proveedor/listar.php">[ Proveedores ]</a>
        <a href="movimiento/listar.php">[ Movimientos ]</a>
        <a href="producto_proveedor/asociar.php">[ Asociar ]</a>
        <a href="consultas/productos_por_categoria.php">[ Consultas ]</a>
    </nav>
</header>

<main>

    <h2>Menú principal</h2>

    <h3>Altas</h3>
    <ul>
        <li><a href="producto/alta.php">Registrar producto</a></li>
        <li><a href="categoria/alta.php">Registrar categoría</a></li>
        <li><a href="proveedor/alta.php">Registrar proveedor</a></li>
        <li><a href="movimiento/alta.php">Registrar movimiento de stock</a></li>
        <li><a href="producto_proveedor/asociar.php">Asociar producto con proveedor</a></li>
    </ul>

    <h3>Listados y operaciones</h3>
    <ul>
        <li><a href="producto/listar.php">Listar y modificar productos</a></li>
        <li><a href="categoria/listar.php">Listar y modificar categorías</a></li>
        <li><a href="proveedor/listar.php">Listar y modificar proveedores</a></li>
        <li><a href="movimiento/listar.php">Listar y eliminar movimientos</a></li>
    </ul>

    <h3>Consultas</h3>
    <ul>
        <li><a href="consultas/productos_por_categoria.php">Productos por categoría</a></li>
        <li><a href="consultas/movimientos_por_producto.php">Movimientos de stock por producto</a></li>
        <li><a href="consultas/productos_por_proveedor.php">Productos por proveedor</a></li>
    </ul>

</main>

<footer>
    <p>Trabajo Práctico — Sistema de Gestión de Inventario</p>
</footer>

</body>
</html>