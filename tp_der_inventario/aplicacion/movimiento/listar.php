<?php
require_once "../conexion.php";

$sql = "SELECT
            m.id_movimiento,
            m.tipo,
            m.fecha,
            m.cantidad,
            m.motivo,
            p.codigo,
            p.nombre AS producto
        FROM movimiento_stock m
        INNER JOIN producto p ON m.id_producto = p.id_producto
        ORDER BY m.fecha DESC";

$stmt = $pdo->query($sql);
$movimientos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de movimientos de stock</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE INVENTARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Movimientos ]</a>
        <a href="alta.php">[ Nuevo movimiento ]</a>
        <a href="../producto/listar.php">[ Productos ]</a>
        <a href="../proveedor/listar.php">[ Proveedores ]</a>
    </nav>
</header>

<main>

    <h2>Listado de movimientos de stock</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Tipo</th>
            <th>Fecha</th>
            <th>Cantidad</th>
            <th>Motivo</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($movimientos as $mov) { ?>
        <tr>
            <td><?= $mov['id_movimiento'] ?></td>
            <td><?= htmlspecialchars($mov['codigo'] . " — " . $mov['producto']) ?></td>
            <td><?= htmlspecialchars($mov['tipo']) ?></td>
            <td><?= htmlspecialchars($mov['fecha']) ?></td>
            <td><?= $mov['cantidad'] ?></td>
            <td><?= htmlspecialchars((string)$mov['motivo']) ?></td>
            <td>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $mov['id_movimiento'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo movimiento</a></p>

</main>

</body>
</html>