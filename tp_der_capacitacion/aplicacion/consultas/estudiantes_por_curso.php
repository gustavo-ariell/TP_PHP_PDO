<?php
require_once "../conexion.php";

$error = "";

// Cargar todos los cursos para el selector
$sqlCursos = "SELECT c.id_curso, c.nombre, c.modalidad, c.duracion,
                     d.nombre AS doc_nombre, d.apellido AS doc_apellido
              FROM curso c
              INNER JOIN docente d ON c.id_docente = d.id_docente
              ORDER BY c.nombre";
$cursos = $pdo->query($sqlCursos)->fetchAll();

$estudiantes = [];
$cursoSeleccionado = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_curso = $_POST["id_curso"] ?? "";

    if ($id_curso === "" || !ctype_digit($id_curso)) {
        $error = "Debe seleccionar un curso.";
    } else {

        $sql = "SELECT e.id_estudiante,
                       e.nombre,
                       e.apellido,
                       e.dni,
                       e.email,
                       e.telefono,
                       MIN(i.fecha_inscripcion) AS fecha_inscripcion,
                       MAX(i.estado) AS estado,
                       MAX(i.calificacion_final) AS calificacion_final
                FROM inscripcion i
                INNER JOIN estudiante e ON i.id_estudiante = e.id_estudiante
                WHERE i.id_curso = :id_curso
                GROUP BY e.id_estudiante, e.nombre, e.apellido, e.dni, e.email, e.telefono
                ORDER BY e.apellido, e.nombre";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_curso' => (int)$id_curso]);
        $estudiantes = $stmt->fetchAll();

        foreach ($cursos as $c) {
            if ($c['id_curso'] == $id_curso) {
                $cursoSeleccionado = $c;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudiantes por curso</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>CONSULTA: ESTUDIANTES POR CURSO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="cursos_por_docente.php">[ Cursos por docente ]</a>
        <a href="../inscripcion/listar.php">[ Inscripciones ]</a>
    </nav>
</header>

<main>

    <?php if ($error !== ""): ?>
        <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <h2>Seleccione un curso</h2>

    <form action="estudiantes_por_curso.php" method="POST">

        <label>Curso</label>
        <select name="id_curso" required>
            <option value="">-- Seleccione un curso --</option>
            <?php foreach ($cursos as $c): ?>
                <option value="<?= $c['id_curso'] ?>">
                    <?= htmlspecialchars($c['nombre'] . " — " . $c['doc_apellido'] . ", " . $c['doc_nombre'] . " (" . $c['modalidad'] . ")") ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Buscar</button>

    </form>

    <?php if ($cursoSeleccionado): ?>

        <h2>
            Estudiantes de:
            <?= htmlspecialchars($cursoSeleccionado['nombre'] . " — " . $cursoSeleccionado['doc_apellido'] . ", " . $cursoSeleccionado['doc_nombre']) ?>
        </h2>

        <p>
            <strong>Modalidad:</strong> <?= htmlspecialchars($cursoSeleccionado['modalidad'] ?? '—') ?>
            &nbsp;|&nbsp;
            <strong>Duración:</strong> <?= htmlspecialchars($cursoSeleccionado['duracion'] ?? '—') ?>
            &nbsp;|&nbsp;
            <strong>Total estudiantes:</strong> <?= count($estudiantes) ?>
        </p>

        <?php if (count($estudiantes) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID estudiante</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Fecha inscripción</th>
                        <th>Estado</th>
                        <th>Calificación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estudiantes as $est): ?>
                        <tr>
                            <td><?= $est['id_estudiante'] ?></td>
                            <td><?= htmlspecialchars($est['nombre']) ?></td>
                            <td><?= htmlspecialchars($est['apellido']) ?></td>
                            <td><?= htmlspecialchars($est['dni']) ?></td>
                            <td><?= htmlspecialchars($est['email'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($est['telefono'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($est['fecha_inscripcion']) ?></td>
                            <td><?= htmlspecialchars($est['estado']) ?></td>
                            <td>
                                <?= $est['calificacion_final'] !== null
                                    ? number_format((float)$est['calificacion_final'], 2, ",", ".")
                                    : '—' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="mensaje error">Este curso no tiene estudiantes inscriptos.</div>
        <?php endif; ?>

    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Cursos de Capacitación</p>
</footer>

</body>
</html>
