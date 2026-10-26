<?php
require_once "../conexion.php";

$sql = "SELECT
            v.id_venta,
            v.fecha,
            v.total,
            c.nombre AS nombre_cliente,
            c.apellido AS apellido_cliente,
            ve.nombre AS nombre_vendedor,
            ve.apellido AS apellido_vendedor,
            fp.nombre AS forma_pago
        FROM venta v
        INNER JOIN cliente c ON v.id_cliente = c.id_cliente
        INNER JOIN vendedor ve ON v.id_vendedor = ve.id_vendedor
        INNER JOIN forma_pago fp ON v.id_forma_pago = fp.id_forma_pago
        ORDER BY v.fecha DESC";

$stmt = $pdo->query($sql);
$ventas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de ventas</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE VENTAS DE LIBRERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Ventas ]</a>
        <a href="alta.php">[ Nueva venta ]</a>
        <a href="../producto/listar.php">[ Productos ]</a>
        <a href="../cliente/listar.php">[ Clientes ]</a>
    </nav>
</header>

<main>

    <h2>Listado de ventas</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Forma de pago</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($ventas as $venta) { ?>
        <tr>
            <td><?= $venta['id_venta'] ?></td>
            <td><?= htmlspecialchars($venta['fecha']) ?></td>
            <td><?= htmlspecialchars($venta['apellido_cliente'] . ", " . $venta['nombre_cliente']) ?></td>
            <td><?= htmlspecialchars($venta['apellido_vendedor'] . ", " . $venta['nombre_vendedor']) ?></td>
            <td><?= htmlspecialchars($venta['forma_pago']) ?></td>
            <td>$<?= number_format((float)$venta['total'], 2, ',', '.') ?></td>
            <td>
                <a class="btn-editar" href="detalle.php?id=<?= $venta['id_venta'] ?>">Ver detalle</a>
                <a class="btn-editar" href="editar.php?id=<?= $venta['id_venta'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $venta['id_venta'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Generar una nueva venta</a></p>

</main>

</body>
</html>