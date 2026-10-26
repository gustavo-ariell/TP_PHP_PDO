<?php
require_once "../conexion.php";

$sql = "SELECT
            h.nombre,
            h.apellido,
            h.dni,
            hab.numero AS habitacion,
            r.fecha_ingreso,
            r.fecha_salida,
            r.estado
        FROM reserva r
        INNER JOIN huesped h ON r.id_huesped = h.id_huesped
        INNER JOIN habitacion hab ON r.id_habitacion = hab.id_habitacion
        WHERE r.estado IN ('activa', 'confirmada')
        ORDER BY r.fecha_ingreso";

$stmt = $pdo->query($sql);
$alojados = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Huéspedes alojados</title>
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

    <h2>Huéspedes alojados</h2>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Habitación</th>
            <th>Ingreso</th>
            <th>Salida</th>
            <th>Estado</th>
        </tr>
        <?php foreach ($alojados as $fila) { ?>
        <tr>
            <td><?= htmlspecialchars($fila['nombre']) ?></td>
            <td><?= htmlspecialchars($fila['apellido']) ?></td>
            <td><?= htmlspecialchars($fila['dni']) ?></td>
            <td><?= htmlspecialchars($fila['habitacion']) ?></td>
            <td><?= htmlspecialchars($fila['fecha_ingreso']) ?></td>
            <td><?= htmlspecialchars($fila['fecha_salida']) ?></td>
            <td><?= htmlspecialchars($fila['estado']) ?></td>
        </tr>
        <?php } ?>
    </table>

</main>

</body>
</html>