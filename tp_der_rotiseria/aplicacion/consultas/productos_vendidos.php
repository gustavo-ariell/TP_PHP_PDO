<?php
require_once "../conexion.php";

$sql = "SELECT
            pr.nombre AS producto,
            c.nombre AS categoria,
            pr.precio,
            SUM(dp.cantidad) AS total_cantidad,
            SUM(dp.subtotal) AS total_monto
        FROM detalle_pedido dp
        INNER JOIN producto pr ON dp.id_producto = pr.id_producto
        LEFT JOIN categoria c ON pr.id_categoria = c.id_categoria
        INNER JOIN pedido p ON dp.id_pedido = p.id_pedido
        WHERE p.estado != 'cancelado'
        GROUP BY pr.id_producto, pr.nombre, c.nombre, pr.precio
        ORDER BY total_cantidad DESC";

$stmt = $pdo->query($sql);
$productos = $stmt->fetchAll();

$total_general = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos vendidos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PEDIDOS — ROTISERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="pedidos_pendientes.php">[ Pendientes ]</a>
        <a href="pedidos_por_cliente.php">[ Por cliente ]</a>
        <a href="productos_vendidos.php">[ Productos vendidos ]</a>
        <a href="../producto/listar.php">[ Productos ]</a>
    </nav>
</header>

<main>

    <h2>Productos vendidos</h2>

    <table>
        <tr>
            <th>Producto</th>
            <th>Categoría</th>
            <th>Precio unitario</th>
            <th>Unidades vendidas</th>
            <th>Monto total</th>
        </tr>
        <?php foreach ($productos as $fila) { $total_general += (float)$fila['total_monto']; ?>
        <tr>
            <td><?= htmlspecialchars($fila['producto']) ?></td>
            <td><?= htmlspecialchars((string)$fila['categoria']) ?></td>
            <td>$<?= number_format((float)$fila['precio'], 2, ',', '.') ?></td>
            <td><strong><?= $fila['total_cantidad'] ?></strong></td>
            <td>$<?= number_format((float)$fila['total_monto'], 2, ',', '.') ?></td>
        </tr>
        <?php } ?>
    </table>

    <p class="total">Monto total vendido: $<?= number_format($total_general, 2, ',', '.') ?></p>

</main>

</body>
</html>