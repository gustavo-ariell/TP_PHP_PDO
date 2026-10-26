<?php
require_once "../conexion.php";

$cursos = $pdo->query("SELECT id_curso, nombre FROM curso ORDER BY nombre")->fetchAll();

$id_curso = $_POST["id_curso"] ?? "";
$participantes = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_curso !== "") {

    $sql = "SELECT
                e.nombre,
                e.apellido,
                e.dni,
                d.nombre AS disciplina,
                i.estado
            FROM inscripcion i
            INNER JOIN estudiante e ON i.id_estudiante = e.id_estudiante
            INNER JOIN disciplina d ON i.id_disciplina = d.id_disciplina
            INNER JOIN curso c ON e.id_curso = c.id_curso
            WHERE c.id_curso = :id_curso
            ORDER BY e.apellido, e.nombre";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_curso' => (int)$id_curso]);
    $participantes = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Participantes por curso</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE INSCRIPCIÓN A OLIMPIADAS ESCOLARES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="estudiantes_inscritos.php">[ Inscritos ]</a>
        <a href="participantes_por_disciplina.php">[ Por disciplina ]</a>
        <a href="participantes_por_curso.php">[ Por curso ]</a>
        <a href="participantes_por_provincia.php">[ Por provincia ]</a>
        <a href="../inscripcion/listar.php">[ Inscripciones ]</a>
    </nav>
</header>

<main>

    <h2>Participantes por curso</h2>

    <form action="participantes_por_curso.php" method="post">

        <label for="id_curso">Curso <span class="requerido">*</span></label>
        <select name="id_curso" id="id_curso" required>
            <option value="">Seleccione un curso</option>
            <?php foreach ($cursos as $curso) { ?>
                <option value="<?= $curso['id_curso'] ?>"
                    <?= $curso['id_curso'] == $id_curso ? "selected" : "" ?>>
                    <?= htmlspecialchars($curso['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>

        <table>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Disciplina</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($participantes as $fila) { ?>
            <tr>
                <td><?= htmlspecialchars($fila['nombre']) ?></td>
                <td><?= htmlspecialchars($fila['apellido']) ?></td>
                <td><?= htmlspecialchars($fila['dni']) ?></td>
                <td><?= htmlspecialchars($fila['disciplina']) ?></td>
                <td><?= htmlspecialchars($fila['estado']) ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>