<?php
require_once "../conexion.php";

$vendedores = $pdo->query("SELECT id_vendedor, nombre, apellido FROM vendedor ORDER BY apellido")->fetchAll();

$id_vendedor = $_POST["id_vendedor"] ?? "";
$ventas = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_vendedor !== "") {

    $sql = "SELECT
                v.id_venta,
                v.fecha,
                v.total,
                c.nombre AS nombre_cliente,
                c.apellido AS apellido_cliente,
                ve.nombre AS nombre_vendedor,
                ve.apellido AS apellido_vendedor
            FROM venta v
            INNER JOIN cliente c ON v.id_cliente = c.id_cliente
            INNER JOIN vendedor ve ON v.id_vendedor = ve.id_vendedor
            WHERE ve.id_vendedor = :id_vendedor
            ORDER BY v.fecha DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_vendedor' => (int)$id_vendedor]);
    $ventas = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vendedor responsable</title>
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

    <h2>Ventas por vendedor responsable</h2>

    <form action="vendedor_responsable.php" method="post">

        <label for="id_vendedor">Vendedor <span class="requerido">*</span></label>
        <select name="id_vendedor" id="id_vendedor" required>
            <option value="">Seleccione un vendedor</option>
            <?php foreach ($vendedores as $vendedor) { ?>
                <option value="<?= $vendedor['id_vendedor'] ?>"
                    <?= $vendedor['id_vendedor'] == $id_vendedor ? "selected" : "" ?>>
                    <?= htmlspecialchars($vendedor['apellido'] . ", " . $vendedor['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>

        <table>
            <tr>
                <th>Venta N°</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Vendedor responsable</th>
                <th>Total</th>
            </tr>
            <?php foreach ($ventas as $venta) { ?>
            <tr>
                <td><?= $venta['id_venta'] ?></td>
                <td><?= htmlspecialchars($venta['fecha']) ?></td>
                <td><?= htmlspecialchars($venta['apellido_cliente'] . ", " . $venta['nombre_cliente']) ?></td>
                <td><?= htmlspecialchars($venta['apellido_vendedor'] . ", " . $venta['nombre_vendedor']) ?></td>
                <td>$<?= number_format((float)$venta['total'], 2, ',', '.') ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>