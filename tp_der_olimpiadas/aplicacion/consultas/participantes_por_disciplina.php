<?php
require_once "../conexion.php";

$disciplinas = $pdo->query("SELECT id_disciplina, nombre FROM disciplina ORDER BY nombre")->fetchAll();

$id_disciplina = $_POST["id_disciplina"] ?? "";
$participantes = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_disciplina !== "") {

    $sql = "SELECT
                e.nombre,
                e.apellido,
                e.dni,
                i.fecha_inscripcion,
                i.estado
            FROM inscripcion i
            INNER JOIN estudiante e ON i.id_estudiante = e.id_estudiante
            INNER JOIN disciplina d ON i.id_disciplina = d.id_disciplina
            WHERE d.id_disciplina = :id_disciplina
            ORDER BY e.apellido, e.nombre";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_disciplina' => (int)$id_disciplina]);
    $participantes = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Participantes por disciplina</title>
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

    <h2>Participantes por deporte</h2>

    <form action="participantes_por_disciplina.php" method="post">

        <label for="id_disciplina">Disciplina <span class="requerido">*</span></label>
        <select name="id_disciplina" id="id_disciplina" required>
            <option value="">Seleccione una disciplina</option>
            <?php foreach ($disciplinas as $disciplina) { ?>
                <option value="<?= $disciplina['id_disciplina'] ?>"
                    <?= $disciplina['id_disciplina'] == $id_disciplina ? "selected" : "" ?>>
                    <?= htmlspecialchars($disciplina['nombre']) ?>
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
                <th>Fecha inscripción</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($participantes as $fila) { ?>
            <tr>
                <td><?= htmlspecialchars($fila['nombre']) ?></td>
                <td><?= htmlspecialchars($fila['apellido']) ?></td>
                <td><?= htmlspecialchars($fila['dni']) ?></td>
                <td><?= htmlspecialchars($fila['fecha_inscripcion']) ?></td>
                <td><?= htmlspecialchars($fila['estado']) ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>