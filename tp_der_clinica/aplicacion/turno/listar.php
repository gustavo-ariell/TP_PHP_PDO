<?php
require_once "../conexion.php";

$sql = "SELECT
            t.id_turno,
            t.fecha,
            t.hora,
            t.estado,
            p.nombre AS nombre_paciente,
            p.apellido AS apellido_paciente,
            m.nombre AS nombre_medico,
            m.apellido AS apellido_medico,
            c.numero AS consultorio
        FROM turno t
        INNER JOIN paciente p ON t.id_paciente = p.id_paciente
        INNER JOIN medico m ON t.id_medico = m.id_medico
        INNER JOIN consultorio c ON t.id_consultorio = c.id_consultorio
        ORDER BY t.fecha DESC, t.hora DESC";

$stmt = $pdo->query($sql);
$turnos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de turnos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TURNOS CLÍNICA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Turnos ]</a>
        <a href="alta.php">[ Nuevo turno ]</a>
        <a href="../paciente/listar.php">[ Pacientes ]</a>
        <a href="../medico/listar.php">[ Médicos ]</a>
    </nav>
</header>

<main>

    <h2>Listado de turnos</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Paciente</th>
            <th>Médico</th>
            <th>Consultorio</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($turnos as $turno) { ?>
        <tr>
            <td><?= $turno['id_turno'] ?></td>
            <td><?= htmlspecialchars($turno['apellido_paciente'] . ", " . $turno['nombre_paciente']) ?></td>
            <td><?= htmlspecialchars($turno['apellido_medico'] . ", " . $turno['nombre_medico']) ?></td>
            <td><?= htmlspecialchars($turno['consultorio']) ?></td>
            <td><?= htmlspecialchars($turno['fecha']) ?></td>
            <td><?= htmlspecialchars($turno['hora']) ?></td>
            <td><?= htmlspecialchars($turno['estado']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $turno['id_turno'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $turno['id_turno'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Solicitar un nuevo turno</a></p>

</main>

</body>
</html>