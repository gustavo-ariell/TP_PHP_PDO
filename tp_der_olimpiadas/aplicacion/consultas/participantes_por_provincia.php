<?php
require_once "../conexion.php";

$provincias = $pdo->query("SELECT id_provincia, nombre FROM provincia ORDER BY nombre")->fetchAll();

$id_provincia = $_POST["id_provincia"] ?? "";
$participantes = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_provincia !== "") {

    $sql = "SELECT
                e.nombre,
                e.apellido,
                e.dni,
                d.nombre AS disciplina,
                pr.nombre AS provincia,
                i.estado
            FROM inscripcion i
            INNER JOIN estudiante e ON i.id_estudiante = e.id_estudiante
            INNER JOIN disciplina d ON i.id_disciplina = d.id_disciplina
            INNER JOIN provincia pr ON e.id_provincia = pr.id_provincia
            WHERE pr.id_provincia = :id_provincia
            ORDER BY e.apellido, e.nombre";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_provincia' => (int)$id_provincia]);
    $participantes = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Participantes por provincia</title>
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

    <h2>Participantes por provincia</h2>

    <form action="participantes_por_provincia.php" method="post">

        <label for="id_provincia">Provincia <span class="requerido">*</span></label>
        <select name="id_provincia" id="id_provincia" required>
            <option value="">Seleccione una provincia</option>
            <?php foreach ($provincias as $provincia) { ?>
                <option value="<?= $provincia['id_provincia'] ?>"
                    <?= $provincia['id_provincia'] == $id_provincia ? "selected" : "" ?>>
                    <?= htmlspecialchars($provincia['nombre']) ?>
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
                <th>Provincia</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($participantes as $fila) { ?>
            <tr>
                <td><?= htmlspecialchars($fila['nombre']) ?></td>
                <td><?= htmlspecialchars($fila['apellido']) ?></td>
                <td><?= htmlspecialchars($fila['dni']) ?></td>
                <td><?= htmlspecialchars($fila['disciplina']) ?></td>
                <td><?= htmlspecialchars($fila['provincia']) ?></td>
                <td><?= htmlspecialchars($fila['estado']) ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>