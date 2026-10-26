<?php
require_once "../conexion.php";

$docentes = $pdo->query("SELECT id_docente, nombre, apellido FROM docente ORDER BY apellido")->fetchAll();

$id_docente = $_POST["id_docente"] ?? "";
$cursos = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_docente !== "") {

    $sql = "SELECT
                c.nombre AS curso,
                c.descripcion,
                c.duracion,
                c.modalidad,
                d.nombre AS nombre_docente,
                d.apellido AS apellido_docente,
                COUNT(i.id_inscripcion) AS total_inscripciones
            FROM curso c
            INNER JOIN docente d ON c.id_docente = d.id_docente
            LEFT JOIN inscripcion i ON c.id_curso = i.id_curso
            WHERE d.id_docente = :id_docente
            GROUP BY c.id_curso, c.nombre, c.descripcion, c.duracion, c.modalidad, d.nombre, d.apellido
            ORDER BY c.nombre";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_docente' => (int)$id_docente]);
    $cursos = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cursos por docente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE CURSOS DE CAPACITACIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="estudiantes_por_curso.php">[ Estudiantes por curso ]</a>
        <a href</a>
        <a href="../inscripcion/listar.php">[ Inscripciones ]</a>
    </nav>
</header>

<main>

    <h2>Cursos por docente</h2>

    <form action="cursos_por_docente.php" method="post">

        <label for="id_docente">Docente <span class="requerido">*</span></label>
        <select name="id_docente" id="id_docente" required>
            <option value="">Seleccione un docente</option>
            <?php foreach ($docentes as $docente) { ?>
                <option value="<?= $docente['id_docente'] ?>"
                    <?= $docente['id_docente'] == $id_docente ? "selected" : "" ?>>
                    <?= htmlspecialchars($docente['apellido'] . ", " . $docente['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>

        <table>
            <tr>
                <th>Curso</th>
                <th>Descripción</th>
                <th>Duración</th>
                <th>Modalidad</th>
                <th>Docente</th>
                <th>Inscripciones</th>
            </tr>
            <?php foreach ($cursos as $fila) { ?>
            <tr>
                <td><?= htmlspecialchars($fila['curso']) ?></td>
                <td><?= htmlspecialchars((string)$fila['descripcion']) ?></td>
                <td><?= htmlspecialchars((string)$fila['duracion']) ?></td>
                <td><?= htmlspecialchars((string)$fila['modalidad']) ?></td>
                <td><?= htmlspecialchars($fila['apellido_docente'] . ", " . $fila['nombre_docente']) ?></td>
                <td><?= $fila['total_inscripciones'] ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>