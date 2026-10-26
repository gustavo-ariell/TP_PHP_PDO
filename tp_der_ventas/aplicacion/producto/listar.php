<?php
require_once "../conexion.php";

$sql = "SELECT
            p.id_producto,
            p.nombre,
            p.descripcion,
            p.precio,
            p.stock,
            c.nombre AS categoria
        FROM producto p
        LEFT JOIN categoria c ON p.id_categoria = c.id_categoria
        ORDER BY p.nombre";

$stmt = $pdo->query($sql);
$productos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de productos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE VENTAS DE LIBRERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Productos ]</a>
        <a href="alta.php">[ Nuevo producto ]</a>
        <a href="../cliente/listar.php">[ Clientes ]</a>
        <a href="../vendedor/listar.php">[ Vendedores ]</a>
        <a href="../venta/listar.php">[ Ventas ]</a>
    </nav>
</header>

<main>

    <h2>Listado de productos</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($productos as $producto) { ?>
        <tr>
            <td><?= $producto['id_producto'] ?></td>
            <td><?= htmlspecialchars($producto['nombre']) ?></td>
            <td><?= htmlspecialchars((string)$producto['descripcion']) ?></td>
            <td>$<?= number_format((float)$producto['precio'], 2, ',', '.') ?></td>
            <td><?= $producto['stock'] ?></td>
            <td><?= htmlspecialchars((string)$producto['categoria']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $producto['id_producto'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $producto['id_producto'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo producto</a></p>

</main>

</body>
</html>