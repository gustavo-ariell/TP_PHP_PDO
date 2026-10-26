<?php
require_once "../conexion.php";

$mensaje = "";
$error   = "";
$cur = null;

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {
    $stmt = $pdo->prepare("SELECT * FROM curso WHERE id_curso = :id");
    $stmt->execute([":id" => $_GET["id"]]);
    $cur = $stmt->fetch();
    if (!$cur) $error = "El curso solicitado no existe.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id             = $_POST["id_curso"] ?? "";
    $id_instrumento = $_POST["id_instrumento"] ?? "";
    $id_docente     = $_POST["id_docente"] ?? "";
    $dia            = trim($_POST["dia"] ?? "");
    $horario        = $_POST["horario"] ?? "";
    $cupo_maximo    = $_POST["cupo_maximo"] ?? "";

    if (!ctype_digit($id)) {
        $error = "Identificador inválido.";
    } elseif (!ctype_digit($id_instrumento) || !ctype_digit($id_docente)) {
        $error = "Debe seleccionar un instrumento y un docente.";
    } elseif ($dia === "" || $horario === "") {
        $error = "Debe ingresar el día y el horario.";
    } elseif (!ctype_digit($cupo_maximo) || (int)$cupo_maximo < 1) {
        $error = "El cupo máximo debe ser mayor que cero.";
    } else {

        try {

            $sql = "UPDATE curso
                    SET id_instrumento = :id_instrumento,
                        id_docente = :id_docente,
                        dia = :dia, horario = :horario,
                        cupo_maximo = :cupo_maximo
                    WHERE id_curso = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":id_instrumento" => $id_instrumento,
                ":id_docente"     => $id_docente,
                ":dia"            => $dia,
                ":horario"        => $horario,
                ":cupo_maximo"    => (int)$cupo_maximo,
                ":id"             => $id
            ]);

            $mensaje = "Curso modificado correctamente.";

            $stmt2 = $pdo->prepare("SELECT * FROM curso WHERE id_curso = :id");
            $stmt2->execute([":id" => $id]);
            $cur = $stmt2->fetch();

        } catch (PDOException $e) {
            $error = "No se pudo modificar el curso.";
        }
    }
}

$instrumentos = $pdo->query("SELECT id_instrumento, nombre FROM instrumento ORDER BY nombre")->fetchAll();
$sqlDoc = "SELECT d.id_docente, d.nombre, d.apellido, i.nombre AS instrumento
           FROM docente d
           INNER JOIN instrumento i ON d.id_instrumento = i.id_instrumento
           ORDER BY d.apellido";
$docentes = $pdo->query($sqlDoc)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar curso</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>MODIFICAR CURSO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar cursos ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje exito"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <?php if ($error !== ""): ?>
        <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($cur): ?>
        <h2>Modificar datos del curso</h2>
        <form action="editar.php" method="POST">
            <input type="hidden" name="id_curso" value="<?= $cur['id_curso'] ?>">

            <label>Instrumento <span class="requerido">*</span></label>
            <select name="id_instrumento" required>
                <?php foreach ($instrumentos as $inst): ?>
                    <option value="<?= $inst['id_instrumento'] ?>"
                        <?= ($inst['id_instrumento'] == $cur['id_instrumento']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($inst['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Docente <span class="requerido">*</span></label>
            <select name="id_docente" required>
                <?php foreach ($docentes as $doc): ?>
                    <option value="<?= $doc['id_docente'] ?>"
                        <?= ($doc['id_docente'] == $cur['id_docente']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($doc['apellido'] . ", " . $doc['nombre'] . " (" . $doc['instrumento'] . ")") ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Día <span class="requerido">*</span></label>
            <select name="dia" required>
                <?php
                $dias = ["Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
                foreach ($dias as $d): ?>
                    <option value="<?= $d ?>" <?= ($cur['dia'] === $d) ? 'selected' : '' ?>><?= $d ?></option>
                <?php endforeach; ?>
            </select>

            <label>Horario <span class="requerido">*</span></label>
            <input type="time" name="horario" required value="<?= htmlspecialchars($cur['horario']) ?>">

            <label>Cupo máximo <span class="requerido">*</span></label>
            <input type="number" name="cupo_maximo" min="1" required value="<?= $cur['cupo_maximo'] ?>">

            <button type="submit">Guardar cambios</button>
        </form>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>