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
            hab.numero AS habitacion
        FROM reserva r
        INNER JOIN huesped h ON r.id_huesped = h.id_huesped
        INNER JOIN habitacion hab ON r.id_habitacion = hab.id_habitacion
        ORDER BY r.fecha_ingreso DESC";

$stmt = $pdo->query($sql);
$reservas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de reservas</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Reservas ]</a>
        <a href="alta.php">[ Nueva reserva ]</a>
        <a href="../huesped/listar.php">[ Huéspedes ]</a>
        <a href="../habitacion/listar.php">[ Habitaciones ]</a>
    </nav>
</header>

<main>

    <h2>Listado de reservas</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Huésped</th>
            <th>Habitación</th>
            <th>Ingreso</th>
            <th>Salida</th>
            <th>Personas</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($reservas as $reserva) { ?>
        <tr>
            <td><?= $reserva['id_reserva'] ?></td>
            <td><?= htmlspecialchars($reserva['apellido_huesped'] . ", " . $reserva['nombre_huesped']) ?></td>
            <td><?= htmlspecialchars($reserva['habitacion']) ?></td>
            <td><?= htmlspecialchars($reserva['fecha_ingreso']) ?></td>
            <td><?= htmlspecialchars($reserva['fecha_salida']) ?></td>
            <td><?= $reserva['cantidad_personas'] ?></td>
            <td><?= htmlspecialchars($reserva['estado']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $reserva['id_reserva'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $reserva['id_reserva'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Generar una nueva reserva</a></p>

</main>

</body>
</html>