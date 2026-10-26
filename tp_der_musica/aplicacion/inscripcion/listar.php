<?php
require_once "../conexion.php";

$sql = "SELECT ins.id_inscripcion,
               ins.fecha_inscripcion,
               e.nombre AS est_nombre,
               e.apellido AS est_apellido,
               i.nombre AS instrumento,
               c.dia,
               c.horario,
               d.nombre AS doc_nombre,
               d.apellido AS doc_apellido
        FROM inscripcion ins
        INNER JOIN estudiante e ON ins.id_estudiante = e.id_estudiante
        INNER JOIN curso c ON ins.id_curso = c.id_curso
        INNER JOIN instrumento i ON c.id_instrumento = i.id_instrumento
        INNER JOIN docente d ON c.id_docente = d.id_docente
        ORDER BY ins.fecha_inscripcion DESC";

$inscripciones = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar inscripciones</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>INSCRIPCIONES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="alta.php">[ Realizar inscripción ]</a>
    </nav>
</header>

<main>

    <h2>Listado de inscripciones</h2>

    <?php if (count($inscripciones) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Estudiante</th>
                    <th>Instrumento</th>
                    <th>Docente</th>
                    <th>Día</th>
                    <th>Horario</th>
                    <th>Fecha inscripción</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inscripciones as $ins): ?>
                    <tr>
                        <td><?= $ins['id_inscripcion'] ?></td>
                        <td><?= htmlspecialchars($ins['est_apellido'] . ", " . $ins['est_nombre']) ?></td>
                        <td><?= htmlspecialchars($ins['instrumento']) ?></td>
                        <td><?= htmlspecialchars($ins['doc_apellido'] . ", " . $ins['doc_nombre']) ?></td>
                        <td><?= htmlspecialchars($ins['dia']) ?></td>
                        <td><?= htmlspecialchars($ins['horario']) ?></td>
                        <td><?= htmlspecialchars($ins['fecha_inscripcion']) ?></td>
                        <td>
                            <a class="btn-eliminar" href="eliminar.php?id=<?= $ins['id_inscripcion'] ?>"
                               onclick="return confirm('¿Eliminar inscripción?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">No hay inscripciones registradas.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>
