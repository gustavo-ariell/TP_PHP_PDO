<?php
require_once "../conexion.php";

$sql = "SELECT id_paciente, nombre, apellido, dni, fecha_nacimiento, telefono, obra_social
        FROM paciente ORDER BY apellido, nombre";

$stmt = $pdo->query($sql);
$pacientes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de pacientes</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TURNOS CLÍNICA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Pacientes ]</a>
        <a href="alta.php">[ Nuevo paciente ]</a>
        <a href="../medico/listar.php">[ Médicos ]</a>
        <a href="../turno/listar.php">[ Turnos ]</a>
    </nav>
</header>

<main>

    <h2>Listado de pacientes</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Fecha nacimiento</th>
            <th>Teléfono</th>
            <th>Obra social</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($pacientes as $paciente) { ?>
        <tr>
            <td><?= $paciente['id_paciente'] ?></td>
            <td><?= htmlspecialchars($paciente['nombre']) ?></td>
            <td><?= htmlspecialchars($paciente['apellido']) ?></td>
            <td><?= htmlspecialchars($paciente['dni']) ?></td>
            <td><?= htmlspecialchars((string)$paciente['fecha_nacimiento']) ?></td>
            <td><?= htmlspecialchars((string)$paciente['telefono']) ?></td>
            <td><?= htmlspecialchars((string)$paciente['obra_social']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $paciente['id_paciente'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $paciente['id_paciente'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo paciente</a></p>

</main>

</body>
</html>