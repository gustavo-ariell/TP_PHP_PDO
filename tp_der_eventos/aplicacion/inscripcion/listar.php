<?php
require_once "../conexion.php";

$sql = "SELECT
            i.id_inscripcion,
            i.fecha_inscripcion,
            a.nombre AS nombre_asistente,
            a.apellido AS apellido_asistente,
            a.dni,
            a.institucion,
            e.nombre AS evento,
            e.fecha AS fecha_evento
        FROM inscripcion_evento i
        INNER JOIN asistente a ON i.id_asistente = a.id_asistente
        INNER JOIN evento e ON i.id_evento = e.id_evento
        ORDER BY i.fecha_inscripcion DESC";

$stmt = $pdo->query($sql);
$inscripciones = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de inscripciones</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Inscripciones ]</a>
        <a href="alta.php">[ Nueva inscripción ]</a>
        <a href="../asistente/listar.php">[ Asistentes ]</a>
        <a href="../evento/listar.php">[ Eventos ]</a>
    </nav>
</header>

<main>

    <h2>Listado de inscripciones</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Asistente</th>
            <th>DNI</th>
            <th>Institución</th>
            <th>Evento</th>
            <th>Fecha evento</th>
            <th>Fecha inscripción</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($inscripciones as $inscripcion) { ?>
        <tr>
            <td><?= $inscripcion['id_inscripcion'] ?></td>
            <td><?= htmlspecialchars($inscripcion['apellido_asistente'] . ", " . $inscripcion['nombre_asistente']) ?></td>
            <td><?= htmlspecialchars($inscripcion['dni']) ?></td>
            <td><?= htmlspecialchars((string)$inscripcion['institucion']) ?></td>
            <td><?= htmlspecialchars($inscripcion['evento']) ?></td>
            <td><?= htmlspecialchars($inscripcion['fecha_evento']) ?></td>
            <td><?= htmlspecialchars($inscripcion['fecha_inscripcion']) ?></td>
            <td>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $inscripcion['id_inscripcion'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Realizar una nueva inscripción</a></p>

</main>

</body>
</html>