<?php
require_once "../conexion.php";

$sql = "SELECT
            r.id_reparacion,
            r.fecha_ingreso,
            r.fecha_salida,
            r.diagnostico,
            r.estado,
            v.patente,
            v.marca,
            v.modelo,
            c.nombre AS nombre_cliente,
            c.apellido AS apellido_cliente,
            m.nombre AS nombre_mecanico,
            m.apellido AS apellido_mecanico
        FROM reparacion r
        INNER JOIN vehiculo v ON r.id_vehiculo = v.id_vehiculo
        INNER JOIN cliente c ON v.id_cliente = c.id_cliente
        INNER JOIN mecanico m ON r.id_mecanico = m.id_mecanico
        ORDER BY r.fecha_ingreso DESC";

$stmt = $pdo->query($sql);
$reparaciones = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de reparaciones</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Reparaciones ]</a>
        <a href="alta.php">[ Nueva reparación ]</a>
        <a href="asociar.php">[ Asociar servicios ]</a>
        <a href="../vehiculo/listar.php">[ Vehículos ]</a>
        <a href="../servicio/listar.php">[ Servicios ]</a>
    </nav>
</header>

<main>

    <h2>Listado de reparaciones</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Vehículo</th>
            <th>Cliente</th>
            <th>Mecánico</th>
            <th>Ing.</th>
            <th>Sal.</th>
            <th>Diagnóstico</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($reparaciones as $rep) { ?>
        <tr>
            <td><?= $rep['id_reparacion'] ?></td>
            <td><?= htmlspecialchars($rep['patente'] . " (" . $rep['marca'] . " " . $rep['modelo'] . ")") ?></td>
            <td><?= htmlspecialchars($rep['apellido_cliente'] . ", " . $rep['nombre_cliente']) ?></td>
            <td><?= htmlspecialchars($rep['apellido_mecanico'] . ", " . $rep['nombre_mecanico']) ?></td>
            <td><?= htmlspecialchars($rep['fecha_ingreso']) ?></td>
            <td><?= $rep['fecha_salida'] !== null ? htmlspecialchars($rep['fecha_salida']) : "—" ?></td>
            <td><?= htmlspecialchars((string)$rep['diagnostico']) ?></td>
            <td><?= htmlspecialchars($rep['estado']) ?></td>
            <td>
                <a class="btn-editar" href="asociar.php?id=<?= $rep['id_reparacion'] ?>">Servicios</a>
                <a class="btn-editar" href="editar.php?id=<?= $rep['id_reparacion'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $rep['id_reparacion'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar una nueva reparación</a></p>

</main>

</body>
</html>