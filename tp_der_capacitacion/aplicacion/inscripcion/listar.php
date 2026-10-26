<?php
require_once "../conexion.php";

$sql = "SELECT
            i.id_inscripcion,
            i.fecha_inscripcion,
            i.estado,
            i.calificacion_final,
            e.nombre AS nombre_estudiante,
            e.apellido AS apellido_estudiante,
            e.dni,
            c.nombre AS curso,
            d.nombre AS nombre_docente,
            d.apellido AS apellido_docente
        FROM inscripcion i
        INNER JOIN estudiante e ON i.id_estudiante = e.id_estudiante
        INNER JOIN curso c ON i.id_curso = c.id_curso
        INNER JOIN docente d ON c.id_docente = d.id_docente
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
    <h1>SISTEMA DE GESTIÓN DE CURSOS DE CAPACITACIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Inscripciones ]</a>
        <a href="alta.php">[ Nueva inscripción ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
        <a href="../curso/listar.php">[ Cursos ]</a>
    </nav>
</header>

<main>

    <h2>Listado de inscripciones</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Estudiante</th>
            <th>DNI</th>
            <th>Curso</th>
            <th>Docente</th>
            <th>Fecha inscripción</th>
            <th>Estado</th>
            <th>Calificación</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($inscripciones as $inscripcion) { ?>
        <tr>
            <td><?= $inscripcion['id_inscripcion'] ?></td>
            <td><?= htmlspecialchars($inscripcion['apellido_estudiante'] . ", " . $inscripcion['nombre_estudiante']) ?></td>
            <td><?= htmlspecialchars($inscripcion['dni']) ?></td>
            <td><?= htmlspecialchars($inscripcion['curso']) ?></td>
            <td><?= htmlspecialchars($inscripcion['apellido_docente'] . ", " . $inscripcion['nombre_docente']) ?></td>
            <td><?= htmlspecialchars($inscripcion['fecha_inscripcion']) ?></td>
            <td><?= htmlspecialchars($inscripcion['estado']) ?></td>
            <td><?= $inscripcion['calificacion_final'] !== null ? $inscripcion['calificacion_final'] : "—" ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $inscripcion['id_inscripcion'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $inscripcion['id_inscripcion'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Realizar una nueva inscripción</a></p>

</main>

</body>
</html>