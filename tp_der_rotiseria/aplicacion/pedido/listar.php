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
            fe.nombre AS forma_entrega,
            r.nombre AS nombre_rep,
            r.apellido AS apellido_rep
        FROM pedido p
        INNER JOIN cliente c ON p.id_cliente = c.id_cliente
        INNER JOIN forma_entrega fe ON p.id_forma_entrega = fe.id_forma_entrega
        LEFT JOIN repartidor r ON p.id_repartidor = r.id_repartidor
        ORDER BY p.fecha DESC, p.hora DESC";

$stmt = $pdo->query($sql);
$pedidos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de pedidos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PEDIDOS — ROTISERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Pedidos ]</a>
        <a href="alta.php">[ Nuevo pedido ]</a>
        <a href="agregar.php">[ Agregar productos ]</a>
        <a href="../cliente/listar.php">[ Clientes ]</a>
        <a href="../producto/listar.php">[ Productos ]</a>
    </nav>
</header>

<main>

    <h2>Listado de pedidos</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
            <th>Entrega</th>
            <th>Dirección</th>
            <th>Repartidor</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($pedidos as $ped) { ?>
        <tr>
            <td><?= $ped['id_pedido'] ?></td>
            <td><?= htmlspecialchars($ped['apellido_cliente'] . ", " . $ped['nombre_cliente']) ?></td>
            <td><?= htmlspecialchars($ped['fecha']) ?></td>
            <td><?= htmlspecialchars($ped['hora']) ?></td>
            <td><?= htmlspecialchars($ped['estado']) ?></td>
            <td><?= htmlspecialchars($ped['forma_entrega']) ?></td>
            <td><?= htmlspecialchars((string)$ped['direccion_entrega']) ?></td>
            <td><?= $ped['nombre_rep'] ? htmlspecialchars($ped['apellido_rep'] . ", " . $ped['nombre_rep']) : "—" ?></td>
            <td>
                <a class="btn-editar" href="agregar.php?id=<?= $ped['id_pedido'] ?>">Productos</a>
                <a class="btn-editar" href="editar.php?id=<?= $ped['id_pedido'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $ped['id_pedido'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo pedido</a></p>

</main>

</body>
</html>