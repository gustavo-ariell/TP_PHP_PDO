<?php
require_once "../conexion.php";

$sql = "SELECT
            p.nombre AS producto,
            SUM(dv.cantidad) AS cantidad_vendida,
            SUM(dv.subtotal) AS total_vendido
        FROM detalle_venta dv
        INNER JOIN producto p ON dv.id_producto = p.id_producto
        GROUP BY p.id_producto, p.nombre
        ORDER BY cantidad_vendida DESC";

$stmt = $pdo->query($sql);
$vendidos = $stmt->fetchAll();
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
    <h1>SISTEMA DE VENTAS DE LIBRERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="productos_vendidos.php">[ Productos vendidos ]</a>
        <a href="total_por_venta.php">[ Total por venta ]</a>
        <a href="vendedor_responsable.php">[ Vendedor responsable ]</a>
        <a href="../venta/listar.php">[ Ventas ]</a>
    </nav>
</header>

<main>

    <h2>Productos vendidos</h2>

    <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad vendida</th>
            <th>Total vendido</th>
        </tr>
        <?php foreach ($vendidos as $fila) { ?>
        <tr>
            <td><?= htmlspecialchars($fila['producto']) ?></td>
            <td><?= $fila['cantidad_vendida'] ?></td>
            <td>$<?= number_format((float)$fila['total_vendido'], 2, ',', '.') ?></td>
        </tr>
        <?php } ?>
    </table>

</main>

</body>
</html>