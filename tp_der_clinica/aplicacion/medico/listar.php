<?php
require_once "../conexion.php";

$sql = "SELECT
            m.id_medico,
            m.nombre,
            m.apellido,
            m.matricula,
            e.nombre AS especialidad
        FROM medico m
        INNER JOIN especialidad e ON m.id_especialidad = e.id_especialidad
        ORDER BY m.apellido, m.nombre";

$stmt = $pdo->query($sql);
$medicos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de médicos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TURNOS CLÍNICA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Médicos ]</a>
        <a href="alta.php">[ Nuevo médico ]</a>
        <a href="../especialidad/listar.php">[ Especialidades ]</a>
        <a href="../turno/listar.php">[ Turnos ]</a>
    </nav>
</header>

<main>

    <h2>Listado de médicos</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Matrícula</th>
            <th>Especialidad</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($medicos as $medico) { ?>
        <tr>
            <td><?= $medico['id_medico'] ?></td>
            <td><?= htmlspecialchars($medico['nombre']) ?></td>
            <td><?= htmlspecialchars($medico['apellido']) ?></td>
            <td><?= htmlspecialchars($medico['matricula']) ?></td>
            <td><?= htmlspecialchars($medico['especialidad']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $medico['id_medico'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $medico['id_medico'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo médico</a></p>

</main>

</body>
</html>