<?php
require_once "../conexion.php";

$sql = "SELECT
            v.id_venta,
            v.fecha,
            c.nombre AS nombre_cliente,
            c.apellido AS apellido_cliente,
            SUM(dv.subtotal) AS total_calculado
        FROM venta v
        INNER JOIN cliente c ON v.id_cliente = c.id_cliente
        INNER JOIN detalle_venta dv ON v.id_venta = dv.id_venta
        GROUP BY v.id_venta, v.fecha, c.nombre, c.apellido
        ORDER BY v.fecha DESC";

$stmt = $pdo->query($sql);
$totales = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Total de cada venta</title>
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

    <h2>Total de cada venta</h2>

    <table>
        <tr>
            <th>Venta N°</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Total</th>
        </tr>
        <?php foreach ($totales as $fila) { ?>
        <tr>
            <td><?= $fila['id_venta'] ?></td>
            <td><?= htmlspecialchars($fila['fecha']) ?></td>
            <td><?= htmlspecialchars($fila['apellido_cliente'] . ", " . $fila['nombre_cliente']) ?></td>
            <td>$<?= number_format((float)$fila['total_calculado'], 2, ',', '.') ?></td>
        </tr>
        <?php } ?>
    </table>

</main>

</body>
</html>