<?php
require_once "../conexion.php";

$reparaciones = $pdo->query(
    "SELECT r.id_reparacion, r.fecha_ingreso, v.patente, v.marca, v.modelo
     FROM reparacion r
     INNER JOIN vehiculo v ON r.id_vehiculo = v.id_vehiculo
     ORDER BY r.fecha_ingreso DESC"
)->fetchAll();

$id_reparacion = $_POST["id_reparacion"] ?? "";
$servicios = [];
$datos_rep = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_reparacion !== "") {

    $sql_datos = "SELECT
                    r.id_reparacion,
                    r.fecha_ingreso,
                    r.estado,
                    v.patente,
                    v.marca,
                    v.modelo,
                    c.nombre AS nombre_cliente,
                    c.apellido AS apellido_cliente
                  FROM reparacion r
                  INNER JOIN vehiculo v ON r.id_vehiculo = v.id_vehiculo
                  INNER JOIN cliente c ON v.id_cliente = c.id_cliente
                  WHERE r.id_reparacion = :id_reparacion";

    $stmt_datos = $pdo->prepare($sql_datos);
    $stmt_datos->execute([':id_reparacion' => (int)$id_reparacion]);
    $datos_rep = $stmt_datos->fetch();

    $sql = "SELECT
                s.nombre AS servicio,
                s.precio,
                rs.cantidad,
                rs.precio_aplicado
            FROM reparacion_servicio rs
            INNER JOIN servicio s ON rs.id_servicio = s.id_servicio
            WHERE rs.id_reparacion = :id_reparacion
            ORDER BY s.nombre";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_reparacion' => (int)$id_reparacion]);
    $servicios = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Servicios por reparación</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="reparaciones_por_vehiculo.php">[ Reparaciones por vehículo ]</a>
        <a href="servicios_por_reparacion.php">[ Servicios por reparación ]</a>
        <a href="vehiculos_por_cliente.php">[ Vehículos por cliente ]</a>
        <a href="../reparacion/listar.php">[ Reparaciones ]</a>
    </nav>
</header>

<main>

    <h2>Servicios incluidos en cada reparación</h2>

    <form action="servicios_por_reparacion.php" method="post">

        <label for="id_reparacion">Reparación <span class="requerido">*</span></label>
        <select name="id_reparacion" id="id_reparacion" required>
            <option value="">Seleccione una reparación</option>
            <?php foreach ($reparaciones as $rep) { ?>
                <option value="<?= $rep['id_reparacion'] ?>"
                    <?= $rep['id_reparacion'] == $id_reparacion ? "selected" : "" ?>>
                    <?= htmlspecialchars("Reparación #" . $rep['id_reparacion'] . " — " . $rep['patente'] . " (" . $rep['marca'] . " " . $rep['modelo'] . ") — " . $rep['fecha_ingreso']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && $datos_rep) { ?>

        <h3>Información de la reparación</h3>
        <p>
            <strong>Vehículo:</strong> <?= htmlspecialchars($datos_rep['patente'] . " — " . $datos_rep['marca'] . " " . $datos_rep['modelo']) ?><br>
            <strong>Cliente:</strong> <?= htmlspecialchars($datos_rep['apellido_cliente'] . ", " . $datos_rep['nombre_cliente']) ?><br>
            <strong>Estado:</strong> <?= htmlspecialchars($datos_rep['estado']) ?>
        </p>

        <table>
            <tr>
                <th>Servicio</th>
                <th>Cantidad</th>
                <th>Precio aplicado</th>
                <th>Subtotal</th>
            </tr>
            <?php $total = 0; ?>
            <?php foreach ($servicios as $fila) { ?>
            <tr>
                <td><?= htmlspecialchars($fila['servicio']) ?></td>
                <td><?= $fila['cantidad'] ?></td>
                <td><?= $fila['precio_aplicado'] !== null ? "$" . number_format((float)$fila['precio_aplicado'], 2, ',', '.') : "—" ?></td>
                <td>
                    <?php
                    if ($fila['precio_aplicado'] !== null) {
                        $subtotal = (float)$fila['precio_aplicado'] * (int)$fila['cantidad'];
                        $total += $subtotal;
                        echo "$" . number_format($subtotal, 2, ',', '.');
                    } else {
                        echo "—";
                    }
                    ?>
                </td>
            </tr>
            <?php } ?>
        </table>

        <?php if ($total > 0) { ?>
            <p><strong>Total: $<?= number_format($total, 2, ',', '.') ?></strong></p>
        <?php } ?>

    <?php } ?>

</main>

</body>
</html>