<?php
require_once "../conexion.php";

$sqlCursos = "SELECT c.id_curso, i.nombre AS instrumento,
                     d.apellido AS doc_apellido, d.nombre AS doc_nombre,
                     c.dia, c.horario
              FROM curso c
              INNER JOIN instrumento i ON c.id_instrumento = i.id_instrumento
              INNER JOIN docente d ON c.id_docente = d.id_docente
              ORDER BY c.dia, c.horario";
$cursos = $pdo->query($sqlCursos)->fetchAll();

$estudiantes = [];
$cursoSeleccionado = null;
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_curso = $_POST["id_curso"] ?? "";

    if (!ctype_digit($id_curso)) {
        $error = "Debe seleccionar un curso.";
    } else {

        $sql = "SELECT e.id_estudiante, e.nombre, e.apellido, e.dni, e.edad, e.telefono,
                       ins.fecha_inscripcion
                FROM inscripcion ins
                INNER JOIN estudiante e ON ins.id_estudiante = e.id_estudiante
                WHERE ins.id_curso = :id_curso
                ORDER BY e.apellido";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id_curso" => $id_curso]);
        $estudiantes = $stmt->fetchAll();

        foreach ($cursos as $c) {
            if ($c['id_curso'] == $id_curso) $cursoSeleccionado = $c;
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
        <a href="docentes_por_instrumento.php">[ Docentes por instrumento ]</a>
        <a href="horarios_clases.php">[ Horarios de clases ]</a>
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
                    <?= htmlspecialchars($c['instrumento'] . " — " . $c['doc_apellido'] . ", " . $c['doc_nombre'] . " (" . $c['dia'] . " " . $c['horario'] . ")") ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Buscar</button>
    </form>

    <?php if ($cursoSeleccionado): ?>
        <h2>
            Estudiantes de:
            <?= htmlspecialchars($cursoSeleccionado['instrumento'] . " — " . $cursoSeleccionado['doc_apellido'] . ", " . $cursoSeleccionado['doc_nombre'] . " (" . $cursoSeleccionado['dia'] . " " . $cursoSeleccionado['horario'] . ")") ?>
        </h2>

        <?php if (count($estudiantes) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Edad</th>
                        <th>Teléfono</th>
                        <th>Fecha inscripción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estudiantes as $est): ?>
                        <tr>
                            <td><?= $est['id_estudiante'] ?></td>
                            <td><?= htmlspecialchars($est['nombre']) ?></td>
                            <td><?= htmlspecialchars($est['apellido']) ?></td>
                            <td><?= htmlspecialchars($est['dni']) ?></td>
                            <td><?= $est['edad'] !== null ? $est['edad'] : '—' ?></td>
                            <td><?= htmlspecialchars($est['telefono'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($est['fecha_inscripcion']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
           : DOCENTES POR INSTRUMENTO</h1>
    <nav>
        ->prepare($sql);
        $stmt->execute([":id_instrumento" => $id_instrumento]);
 <div class="mensaje error">Este curso no tiene estudiantes inscriptos.</div>
        <?php endif; ?>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>