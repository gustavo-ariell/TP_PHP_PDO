<?php
require_once "../conexion.php";

$sql = "SELECT
            p.fecha_pago,
            p.monto,
            p.metodo_pago,
            r.id_reserva,
            h.nombre AS nombre_huesped,
            h.apellido AS apellido_huesped,
            hab.numero AS habitacion
        FROM pago p
        INNER JOIN reserva r ON p.id_reserva = r.id_reserva
        INNER JOIN huesped h ON r.id_huesped = h.id_huesped
        INNER JOIN habitacion hab ON r.id_habitacion = hab.id_habitacion
        ORDER BY p.fecha_pago DESC";

$stmt = $pdo->query($sql);
$pagos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagos realizados</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="habitaciones.php">[ Habitaciones ]</a>
        <a href="huespedes_alojados.php">[ Huéspedes alojados ]</a>
        <a href="reservas_activas.php">[ Reservas activas ]</a>
        <a href="pagos_realizados.php">[ Pagos realizados ]</a>
        <a href="../pago/listar.php">[ Pagos ]</a>
    </nav>
</header>

<main>

    <h2>Pagos realizados</h2>

    <table>
        <tr>
            <th>Reserva</th>
            <th>Huésped</th>
            <th>Habitación</th>
            <th>Fecha pago</th>
            <th>Monto</th>
            <th>Método</th>
        </tr>
        <?php foreach ($pagos as $pago) { ?>
        <tr>
            <td><?= $pago['id_reserva'] ?></td>
            <td><?= htmlspecialchars($pago['apellido_huesped'] . ", " . $pago['nombre_huesped']) ?></td>
            <td><?= htmlspecialchars($pago['habitacion']) ?></td>
            <td><?= htmlspecialchars($pago['fecha_pago']) ?></td>
            <td>$<?= number_format((float)$pago['monto'], 2, ',', '.') ?></td>
            <td><?= htmlspecialchars((string)$pago['metodo_pago']) ?></td>
        </tr>
        <?php } ?>
    </table>

</main>

</body>
</html>