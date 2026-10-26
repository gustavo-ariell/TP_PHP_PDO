<?php
require_once "../conexion.php";

$mensaje = "";
$error   = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_instrumento = $_POST["id_instrumento"] ?? "";
    $id_docente     = $_POST["id_docente"] ?? "";
    $dia            = trim($_POST["dia"] ?? "");
    $horario        = $_POST["horario"] ?? "";
    $cupo_maximo    = $_POST["cupo_maximo"] ?? "";

    if (!ctype_digit($id_instrumento) || !ctype_digit($id_docente)) {
        $error = "Debe seleccionar un instrumento y un docente.";
    } elseif ($dia === "" || $horario === "") {
        $error = "Debe ingresar el día y el horario.";
    } elseif (!ctype_digit($cupo_maximo) || (int)$cupo_maximo < 1) {
        $error = "El cupo máximo debe ser un número entero mayor que cero.";
    } else {

        try {

            $sql = "INSERT INTO curso (id_instrumento, id_docente, dia, horario, cupo_maximo)
                    VALUES (:id_instrumento, :id_docente, :dia, :horario, :cupo_maximo)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":id_instrumento" => $id_instrumento,
                ":id_docente"     => $id_docente,
                ":dia"            => $dia,
                ":horario"        => $horario,
                ":cupo_maximo"    => (int)$cupo_maximo
            ]);

            $mensaje = "Curso registrado correctamente.";

        } catch (PDOException $e) {
            $error = "No se pudo registrar el curso.";
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
    <title>Registrar curso</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>REGISTRAR CURSO</h1>
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

    <h2>Nuevo curso</h2>

    <form action="alta.php" method="POST">
        <label>Instrumento <span class="requerido">*</span></label>
        <select name="id_instrumento" required>
            <option value="">-- Seleccione un instrumento --</option>
            <?php foreach ($instrumentos as $inst): ?>
                <option value="<?= $inst['id_instrumento'] ?>">
                    <?= htmlspecialchars($inst['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Docente <span class="requerido">*</span></label>
        <select name="id_docente" required>
            <option value="">-- Seleccione un docente --</option>
            <?php foreach ($docentes as $doc): ?>
                <option value="<?= $doc['id_docente'] ?>">
                    <?= htmlspecialchars($doc['apellido'] . ", " . $doc['nombre'] . " (" . $doc['instrumento'] . ")") ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Día <span class="requerido">*</span></label>
        <select name="dia" required>
            <option value="">-- Seleccione un día --</option>
            <option value="Lunes">Lunes</option>
            <option value="Martes">Martes</option>
            <option value="Miércoles">Miércoles</option>
            <option value="Jueves">Jueves</option>
            <option value="Viernes">Viernes</option>
            <option value="Sábado">Sábado</option>
        </select>

        <label>Horario <span class="requerido">*</span></label>
        <input type="time" name="horario" required>

        <label>Cupo máximo <span class="requerido">*</span></label>
        <input type="number" name="cupo_maximo" min="1" required>

        <button type="submit">Registrar</button>
    </form>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>