<?php
require_once "../conexion.php";

$sql = "SELECT
            r.id_reserva,
            r.fecha_ingreso,
            r.fecha_salida,
            r.cantidad_personas,
            r.estado,
            h.nombre AS nombre_huesped,
            h.apellido AS apellido_huesped,
            hab.numero AS habitacion,
            th.nombre AS tipo
        FROM reserva r
        INNER JOIN huesped h ON r.id_huesped = h.id_huesped
        INNER JOIN habitacion hab ON r.id_habitacion = hab.id_habitacion
        INNER JOIN tipo_habitacion th ON hab.id_tipo = th.id_tipo
        WHERE r.estado IN ('activa', 'confirmada', 'pendiente')
        ORDER BY r.fecha_ingreso";

$stmt = $pdo->query($sql);
$activas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas activas</title>
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

    <h2>Reservas activas</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Huésped</th>
            <th>Habitación</th>
            <th>Tipo</th>
            <th>Ingreso</th>
            <th>Salida</th>
            <th>Personas</th>
            <th>Estado</th>
        </tr>
        <?php foreach ($activas as $fila) { ?>
        <tr>
            <td><?= $fila['id_reserva'] ?></td>
            <td><?= htmlspecialchars($fila['apellido_huesped'] . ", " . $fila['nombre_huesped']) ?></td>
            <td><?= htmlspecialchars($fila['habitacion']) ?></td>
            <td><?= htmlspecialchars($fila['tipo']) ?></td>
            <td><?= htmlspecialchars($fila['fecha_ingreso']) ?></td>
            <td><?= htmlspecialchars($fila['fecha_salida']) ?></td>
            <td><?= $fila['cantidad_personas'] ?></td>
            <td><?= htmlspecialchars($fila['estado']) ?></td>
        </tr>
        <?php } ?>
    </table>

</main>

</body>
</html>