<?php
require_once "../conexion.php";

$clientes = $pdo->query("SELECT id_cliente, nombre, apellido, dni FROM cliente ORDER BY apellido")->fetchAll();

$id_cliente = $_POST["id_cliente"] ?? "";
$pedidos = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_cliente !== "") {

    $sql = "SELECT
                p.id_pedido,
                p.fecha,
                p.hora,
                p.estado,
                p.direccion_entrega,
                fe.nombre AS forma_entrega,
                r.nombre AS nombre_rep,
                r.apellido AS apellido_rep
            FROM pedido p
            INNER JOIN cliente c ON p.id_cliente = c.id_cliente
            INNER JOIN forma_entrega fe ON p.id_forma_entrega = fe.id_forma_entrega
            LEFT JOIN repartidor r ON p.id_repartidor = r.id_repartidor
            WHERE p.id_cliente = :id_cliente
            ORDER BY p.fecha DESC, p.hora DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_cliente' => (int)$id_cliente]);
    $pedidos = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedidos por cliente</title>
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

    <h2>Pedidos por cliente</h2>

    <form action="pedidos_por_cliente.php" method="post">

        <label for="id_cliente">Cliente <span class="requerido">*</span></label>
        <select name="id_cliente" id="id_cliente" required>
            <option value="">Seleccione un cliente</option>
            <?php foreach ($clientes as $cliente) { ?>
                <option value="<?= $cliente['id_cliente'] ?>"
                    <?= $cliente['id_cliente'] == $id_cliente ? "selected" : "" ?>>
                    <?= htmlspecialchars($cliente['apellido'] . ", " . $cliente['nombre'] . " (DNI: " . $cliente['dni'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>

        <table>
            <tr>
                <th>ID</th>
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
                <td><?= htmlspecialchars($ped['fecha']) ?></td>
                <td><?= htmlspecialchars($ped['hora']) ?></td>
                <td><?= htmlspecialchars($ped['estado']) ?></td>
                <td><?= htmlspecialchars($ped['forma_entrega']) ?></td>
                <td><?= htmlspecialchars((string)$ped['direccion_entrega']) ?></td>
                <td><?= $ped['nombre_rep'] ? htmlspecialchars($ped['apellido_rep'] . ", " . $ped['nombre_rep']) : "—" ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>