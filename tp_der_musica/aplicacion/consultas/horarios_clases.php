<?php
require_once "../conexion.php";

$sql = "SELECT c.id_curso,
               i.nombre AS instrumento,
               d.nombre AS doc_nombre,
               d.apellido AS doc_apellido,
               c.dia,
               c.horario,
               c.cupo_maximo,
               COUNT(ins.id_inscripcion) AS inscriptos
        FROM curso c
        INNER JOIN instrumento i ON c.id_instrumento = i.id_instrumento
        INNER JOIN docente d ON c.id_docente = d.id_docente
        LEFT JOIN inscripcion ins ON c.id_curso = ins.id_curso
        GROUP BY c.id_curso
        ORDER BY
            FIELD(c.dia, 'Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'),
            c.horario";

$cursos = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Horarios de clases</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>CONSULTA: HORARIOS DE CLASES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="estudiantes_por_curso.php">[ Estudiantes por curso ]</a>
        <a href="docentes_por_instrumento.php">[ Docentes por instrumento ]</a>
    </nav>
</header>

<main>

    <h2>Horario general de clases</h2>

    <?php if (count($cursos) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Día</th>
                    <th>Horario</th>
                    <th>Instrumento</th>
                    <th>Docente</th>
                    <th>Inscriptos</th>
                    <th>Cupo máximo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cursos as $cur): ?>
                    <tr>
                        <td><?= htmlspecialchars($cur['dia']) ?></td>
                        <td><?= htmlspecialchars($cur['horario']) ?></td>
                        <td><?= htmlspecialchars($cur['instrumento']) ?></td>
                        <td><?= htmlspecialchars($cur['doc_apellido'] . ", " . $cur['doc_nombre']) ?></td>
                        <td><?= $cur['inscriptos'] ?></td>
                        <td><?= $cur['cupo_maximo'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">No hay cursos registrados.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>
