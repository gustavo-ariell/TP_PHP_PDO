<?php
require_once "../conexion.php";

$sql = "SELECT
            p.id_pago,
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
    <title>Listado de pagos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Pagos ]</a>
        <a href="alta.php">[ Nuevo pago ]</a>
        <a href="../reserva/listar.php">[ Reservas ]</a>
    </nav>
</header>

<main>

    <h2>Listado de pagos</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Reserva</th>
            <th>Huésped</th>
            <th>Habitación</th>
            <th>Fecha pago</th>
            <th>Monto</th>
            <th>Método</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($pagos as $pago) { ?>
        <tr>
            <td><?= $pago['id_pago'] ?></td>
            <td><?= $pago['id_reserva'] ?></td>
            <td><?= htmlspecialchars($pago['apellido_huesped'] . ", " . $pago['nombre_huesped']) ?></td>
            <td><?= htmlspecialchars($pago['habitacion']) ?></td>
            <td><?= htmlspecialchars($pago['fecha_pago']) ?></td>
            <td>$<?= number_format((float)$pago['monto'], 2, ',', '.') ?></td>
            <td><?= htmlspecialchars((string)$pago['metodo_pago']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $pago['id_pago'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $pago['id_pago'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo pago</a></p>

</main>

</body>
</html>