<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_inscripcion = (int)($_POST["id_inscripcion"] ?? 0);
    $id_estudiante = $_POST["id_estudiante"] ?? "";
    $id_disciplina = $_POST["id_disciplina"] ?? "";
    $fecha_inscripcion = $_POST["fecha_inscripcion"] ?? "";
    $anio_participacion = $_POST["anio_participacion"] ?? "";
    $estado = $_POST["estado"] ?? "";

    if ($id_estudiante === "" || $id_disciplina === "" ||
        $fecha_inscripcion === "" || $anio_participacion === "") {

        $mensaje = "Debe completar todos los campos obligatorios.";
        $tipo_mensaje = "error";

    } elseif (!in_array($estado, ["pendiente", "confirmada", "cancelada"])) {

        $mensaje = "El estado debe ser pendiente, confirmada o cancelada.";
        $tipo_mensaje = "error";

    } else {

        $sql = "UPDATE inscripcion SET
                    id_estudiante = :id_estudiante,
                    id_disciplina = :id_disciplina,
                    fecha_inscripcion = :fecha_inscripcion,
                    anio_participacion = :anio_participacion,
                    estado = :estado
                WHERE id_inscripcion = :id_inscripcion";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_estudiante'      => (int)$id_estudiante,
                ':id_disciplina'      => (int)$id_disciplina,
                ':fecha_inscripcion'  => $fecha_inscripcion,
                ':anio_participacion' => (int)$anio_participacion,
                ':estado'             => $estado,
                ':id_inscripcion'     => $id_inscripcion
            ]);

            $mensaje = "Inscripción modificada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar la inscripción.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_inscripcion"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_inscripcion, id_estudiante, id_disciplina, fecha_inscripcion,
               anio_participacion, estado
        FROM inscripcion
        WHERE id_inscripcion = :id_inscripcion";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_inscripcion' => $id]);
$inscripcion = $stmt->fetch();

if (!$inscripcion) {
    die("La inscripción solicitada no existe.");
}

$estudiantes = $pdo->query("SELECT id_estudiante, nombre, apellido, dni FROM estudiante ORDER BY apellido")->fetchAll();
$disciplinas = $pdo->query("SELECT id_disciplina, nombre FROM disciplina ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar inscripción</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE INSCRIPCIÓN A OLIMPIADAS ESCOLARES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Inscripciones ]</a>
    </nav>
</header>

<main>

    <h2>Modificar estado de inscripción</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_inscripcion" value="<?= $inscripcion['id_inscripcion'] ?>">

        <label for="id_estudiante">Estudiante <span class="requerido">*</span></label>
        <select name="id_estudiante" id="id_estudiante" required>
            <?php foreach ($estudiantes as $estudiante) { ?>
                <option value="<?= $estudiante['id_estudiante'] ?>"
                    <?= $estudiante['id_estudiante'] == $inscripcion['id_estudiante'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($estudiante['apellido'] . ", " . $estudiante['nombre'] . " (DNI: " . $estudiante['dni'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_disciplina">Disciplina <span class="requerido">*</span></label>
        <select name="id_disciplina" id="id_disciplina" required>
            <?php foreach ($disciplinas as $disciplina) { ?>
                <option value="<?= $disciplina['id_disciplina'] ?>"
                    <?= $disciplina['id_disciplina'] == $inscripcion['id_disciplina'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($disciplina['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha_inscripcion">Fecha de inscripción <span class="requerido">*</span></label>
        <input type="date" name="fecha_inscripcion" id="fecha_inscripcion" required
               value="<?= htmlspecialchars($inscripcion['fecha_inscripcion']) ?>">

        <label for="anio_participacion">Año de participación <span class="requerido">*</span></label>
        <input type="number" name="anio_participacion" id="anio_participacion" min="2020" max="2030" required
               value="<?= $inscripcion['anio_participacion'] ?>">

        <label for="estado">Estado <span class="requerido">*</span></label>
        <select name="estado" id="estado" required>
            <option value="pendiente" <?= $inscripcion['estado'] === 'pendiente' ? "selected" : "" ?>>Pendiente</option>
            <option value="confirmada" <?= $inscripcion['estado'] === 'confirmada' ? "selected" : "" ?>>Confirmada</option>
            <option value="cancelada" <?= $inscripcion['estado'] === 'cancelada' ? "selected" : "" ?>>Cancelada</option>
        </select>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>