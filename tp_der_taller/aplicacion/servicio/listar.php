<?php
require_once "../conexion.php";

$sql = "SELECT id_servicio, nombre, descripcion, precio
        FROM servicio ORDER BY nombre";

$stmt = $pdo->query($sql);
$servicios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de servicios</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Servicios ]</a>
        <a href="alta.php">[ Nuevo servicio ]</a>
        <a href="../reparacion/listar.php">[ Reparaciones ]</a>
    </nav>
</header>

<main>

    <h2>Listado de servicios</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($servicios as $servicio) { ?>
        <tr>
            <td><?= $servicio['id_servicio'] ?></td>
            <td><?= htmlspecialchars($servicio['nombre']) ?></td>
            <td><?= htmlspecialchars((string)$servicio['descripcion']) ?></td>
            <td><?= $servicio['precio'] !== null ? "$" . number_format((float)$servicio['precio'], 2, ',', '.') : "—" ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $servicio['id_servicio'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $servicio['id_servicio'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo servicio</a></p>

</main>

</body>
</html>