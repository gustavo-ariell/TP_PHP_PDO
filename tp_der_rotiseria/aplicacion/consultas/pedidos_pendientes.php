<?php
require_once "../conexion.php";

$sql = "SELECT
            p.id_pedido,
            p.fecha,
            p.hora,
            p.estado,
            p.direccion_entrega,
            c.nombre AS nombre_cliente,
            c.apellido AS apellido_cliente,
            c.telefono,
            fe.nombre AS forma_entrega,
            r.nombre AS nombre_rep,
            r.apellido AS apellido_rep
        FROM pedido p
        INNER JOIN cliente c ON p.id_cliente = c.id_cliente
        INNER JOIN forma_entrega fe ON p.id_forma_entrega = fe.id_forma_entrega
        LEFT JOIN repartidor r ON p.id_repartidor = r.id_repartidor
        WHERE p.estado IN ('pendiente', 'en preparacion', 'en camino')
        ORDER BY p.fecha, p.hora";

$stmt = $pdo->query($sql);
$pedidos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedidos pendientes</title>
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
        <a href="../pedido/listar.php">[ Pedidos ]</a>
    </nav>
</header>

<main>

    <h2>Pedidos pendientes</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Teléfono</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
            <th>Entrega</th>
            <th>Dirección</th>
            <th>Repartidor</th>
        </tr>
        <?php foreach ($pedidos as $ped) { ?>
        <tr>
            <td><?= $ped['id_pedido'] ?></td>
            <td><?= htmlspecialchars($ped['apellido_cliente'] . ", " . $ped['nombre_cliente']) ?></td>
            <td><?= htmlspecialchars((string)$ped['telefono']) ?></td>
            <td><?= htmlspecialchars($ped['fecha']) ?></td>
            <td><?= htmlspecialchars($ped['hora']) ?></td>
            <td><?= htmlspecialchars($ped['estado']) ?></td>
            <td><?= htmlspecialchars($ped['forma_entrega']) ?></td>
            <td><?= htmlspecialchars((string)$ped['direccion_entrega']) ?></td>
            <td><?= $ped['nombre_rep'] ? htmlspecialchars($ped['apellido_rep'] . ", " . $ped['nombre_rep']) : "—" ?></td>
        </tr>
        <?php } ?>
    </table>

</main>

</body>
</html>