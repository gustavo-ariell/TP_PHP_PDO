<?php
require_once "../conexion.php";

$sql = "SELECT
            v.id_vehiculo,
            v.patente,
            v.marca,
            v.modelo,
            v.anio,
            tv.nombre AS tipo,
            c.nombre AS nombre_cliente,
            c.apellido AS apellido_cliente
        FROM vehiculo v
        LEFT JOIN tipo_vehiculo tv ON v.id_tipo = tv.id_tipo
        INNER JOIN cliente c ON v.id_cliente = c.id_cliente
        ORDER BY v.patente";

$stmt = $pdo->query($sql);
$vehiculos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de vehículos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Vehículos ]</a>
        <a href="alta.php">[ Nuevo vehículo ]</a>
        <a href="../cliente/listar.php">[ Clientes ]</a>
        <a href="../reparacion/listar.php">[ Reparaciones ]</a>
    </nav>
</header>

<main>

    <h2>Listado de vehículos</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Patente</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Año</th>
            <th>Tipo</th>
            <th>Cliente</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($vehiculos as $vehiculo) { ?>
        <tr>
            <td><?= $vehiculo['id_vehiculo'] ?></td>
            <td><?= htmlspecialchars($vehiculo['patente']) ?></td>
            <td><?= htmlspecialchars($vehiculo['marca']) ?></td>
            <td><?= htmlspecialchars($vehiculo['modelo']) ?></td>
            <td><?= $vehiculo['anio'] !== null ? $vehiculo['anio'] : "—" ?></td>
            <td><?= htmlspecialchars((string)$vehiculo['tipo']) ?></td>
            <td><?= htmlspecialchars($vehiculo['apellido_cliente'] . ", " . $vehiculo['nombre_cliente']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $vehiculo['id_vehiculo'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $vehiculo['id_vehiculo'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo vehículo</a></p>

</main>

</body>
</html>