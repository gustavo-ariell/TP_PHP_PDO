<?php
require_once "../conexion.php";

$sql = "SELECT id_mecanico, nombre, apellido, dni, especialidad
        FROM mecanico ORDER BY apellido, nombre";

$stmt = $pdo->query($sql);
$mecanicos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de mecánicos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Mecánicos ]</a>
        <a href="alta.php">[ Nuevo mecánico ]</a>
        <a href="../reparacion/listar.php">[ Reparaciones ]</a>
        <a href="../vehiculo/listar.php">[ Vehículos ]</a>
    </nav>
</header>

<main>

    <h2>Listado de mecánicos</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Especialidad</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($mecanicos as $mecanico) { ?>
        <tr>
            <td><?= $mecanico['id_mecanico'] ?></td>
            <td><?= htmlspecialchars($mecanico['nombre']) ?></td>
            <td><?= htmlspecialchars($mecanico['apellido']) ?></td>
            <td><?= htmlspecialchars($mecanico['dni']) ?></td>
            <td><?= htmlspecialchars((string)$mecanico['especialidad']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $mecanico['id_mecanico'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $mecanico['id_mecanico'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo mecánico</a></p>

</main>

</body>
</html>