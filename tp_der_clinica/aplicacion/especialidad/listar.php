<?php
require_once "../conexion.php";

$sql = "SELECT id_especialidad, nombre FROM especialidad ORDER BY nombre";

$stmt = $pdo->query($sql);
$especialidades = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de especialidades</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TURNOS CLÍNICA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Especialidades ]</a>
        <a href="alta.php">[ Nueva especialidad ]</a>
        <a href="../medico/listar.php">[ Médicos ]</a>
        <a href="../turno/listar.php">[ Turnos ]</a>
    </nav>
</header>

<main>

    <h2>Listado de especialidades</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($especialidades as $especialidad) { ?>
        <tr>
            <td><?= $especialidad['id_especialidad'] ?></td>
            <td><?= htmlspecialchars($especialidad['nombre']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $especialidad['id_especialidad'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $especialidad['id_especialidad'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar una nueva especialidad</a></p>

</main>

</body>
</html>