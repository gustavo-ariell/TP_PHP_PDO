<?php
require_once "../conexion.php";

$sql = "SELECT
            h.numero,
            h.piso,
            h.capacidad,
            h.precio_noche,
            th.nombre AS tipo,
            th.descripcion
        FROM habitacion h
        INNER JOIN tipo_habitacion th ON h.id_tipo = th.id_tipo
        ORDER BY h.piso, h.numero";

$stmt = $pdo->query($sql);
$habitaciones = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar habitaciones</title>
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
        <a href="../reserva/listar.php">[ Reservas ]</a>
    </nav>
</header>

<main>

    <h2>Consultar habitaciones</h2>

    <table>
        <tr>
            <th>Número</th>
            <th>Piso</th>
            <th>Capacidad</th>
            <th>Tipo</th>
            <th>Descripción</th>
            <th>Precio/noche</th>
        </tr>
        <?php foreach ($habitaciones as $habitacion) { ?>
        <tr>
            <td><?= htmlspecialchars($habitacion['numero']) ?></td>
            <td><?= $habitacion['piso'] ?></td>
            <td><?= $habitacion['capacidad'] ?></td>
            <td><?= htmlspecialchars($habitacion['tipo']) ?></td>
            <td><?= htmlspecialchars((string)$habitacion['descripcion']) ?></td>
            <td>$<?= number_format((float)$habitacion['precio_noche'], 2, ',', '.') ?></td>
        </tr>
        <?php } ?>
    </table>

</main>

</body>
</html>