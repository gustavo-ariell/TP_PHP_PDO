<?php
require_once "../conexion.php";

$sql = "SELECT
            h.id_habitacion,
            h.numero,
            h.piso,
            h.capacidad,
            h.precio_noche,
            th.nombre AS tipo
        FROM habitacion h
        INNER JOIN tipo_habitacion th ON h.id_tipo = th.id_tipo
        ORDER BY h.numero";

$stmt = $pdo->query($sql);
$habitaciones = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de habitaciones</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Habitaciones ]</a>
        <a href="alta.php">[ Nueva habitación ]</a>
        <a href="../huesped/listar.php">[ Huéspedes ]</a>
        <a href="../reserva/listar.php">[ Reservas ]</a>
    </nav>
</header>

<main>

    <h2>Listado de habitaciones</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Número</th>
            <th>Piso</th>
            <th>Capacidad</th>
            <th>Tipo</th>
            <th>Precio/noche</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($habitaciones as $habitacion) { ?>
        <tr>
            <td><?= $habitacion['id_habitacion'] ?></td>
            <td><?= htmlspecialchars($habitacion['numero']) ?></td>
            <td><?= $habitacion['piso'] ?></td>
            <td><?= $habitacion['capacidad'] ?></td>
            <td><?= htmlspecialchars($habitacion['tipo']) ?></td>
            <td>$<?= number_format((float)$habitacion['precio_noche'], 2, ',', '.') ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $habitacion['id_habitacion'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $habitacion['id_habitacion'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar una nueva habitación</a></p>

</main>

</body>
</html>