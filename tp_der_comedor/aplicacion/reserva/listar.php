<?php
require_once "../conexion.php";

$sql = "SELECT
            r.id_reserva,
            r.fecha,
            r.estado,
            e.nombre AS nombre_estudiante,
            e.apellido AS apellido_estudiante,
            m.fecha AS fecha_menu,
            m.descripcion AS descripcion_menu,
            fp.nombre AS forma_pago
        FROM reserva r
        INNER JOIN estudiante e ON r.id_estudiante = e.id_estudiante
        INNER JOIN menu m ON r.id_menu = m.id_menu
        LEFT JOIN forma_pago fp ON r.id_forma_pago = fp.id_forma_pago
        ORDER BY r.fecha DESC";

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
    <h1>SISTEMA DE COMEDOR UNIVERSITARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Reservas ]</a>
        <a href="alta.php">[ Nueva reserva ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
        <a href="../menu/listar.php">[ Menús ]</a>
    </nav>
</header>

<main>

    <h2>Listado de reservas</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Estudiante</th>
            <th>Menú</th>
            <th>Fecha reserva</th>
            <th>Estado</th>
            <th>Forma de pago</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($reservas as $reserva) { ?>
        <tr>
            <td><?= $reserva['id_reserva'] ?></td>
            <td><?= htmlspecialchars($reserva['apellido_estudiante'] . ", " . $reserva['nombre_estudiante']) ?></td>
            <td><?= htmlspecialchars($reserva['fecha_menu'] . " — " . (string)$reserva['descripcion_menu']) ?></td>
            <td><?= htmlspecialchars($reserva['fecha']) ?></td>
            <td><?= htmlspecialchars($reserva['estado']) ?></td>
            <td><?= htmlspecialchars((string)$reserva['forma_pago']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $reserva['id_reserva'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $reserva['id_reserva'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Realizar una nueva reserva</a></p>

</main>

</body>
</html>