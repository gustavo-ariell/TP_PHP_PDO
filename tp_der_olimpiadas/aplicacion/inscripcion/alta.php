<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_estudiante = $_POST["id_estudiante"] ?? "";
    $id_disciplina = $_POST["id_disciplina"] ?? "";
    $fecha_inscripcion = $_POST["fecha_inscripcion"] ?? "";
    $anio_participacion = $_POST["anio_participacion"] ?? "";
    $estado = $_POST["estado"] ?? "";

    if ($id_estudiante === "" || $id_disciplina === "" ||
        $fecha_inscripcion === "" || $anio_participacion === "") {

        $mensaje = "Debe seleccionar un estudiante, una disciplina, ingresar la fecha y el año de participación.";
        $tipo_mensaje = "error";

    } elseif (!in_array($estado, ["pendiente", "confirmada", "cancelada"])) {

        $mensaje = "El estado debe ser pendiente, confirmada o cancelada.";
        $tipo_mensaje = "error";

    } elseif (!is_numeric($anio_participacion)) {

        $mensaje = "El año de participación debe ser un número válido.";
        $tipo_mensaje = "error";

    } else {

        $sql = "INSERT INTO inscripcion
                    (id_estudiante, id_disciplina, fecha_inscripcion, anio_participacion, estado)
                VALUES
                    (:id_estudiante, :id_disciplina, :fecha_inscripcion, :anio_participacion, :estado)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_estudiante'      => (int)$id_estudiante,
                ':id_disciplina'      => (int)$id_disciplina,
                ':fecha_inscripcion'  => $fecha_inscripcion,
                ':anio_participacion' => (int)$anio_participacion,
                ':estado'             => $estado
            ]);

            $mensaje = "Inscripción registrada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar la inscripción.";
            $tipo_mensaje = "error";
        }
    }
}

$estudiantes = $pdo->query("SELECT id_estudiante, nombre, apellido, dni FROM estudiante ORDER BY apellido")->fetchAll();
$disciplinas = $pdo->query("SELECT id_disciplina, nombre FROM disciplina ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Realizar inscripción</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE INSCRIPCIÓN A OLIMPIADAS ESCOLARES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Inscripciones ]</a>
        <a href="alta.php">[ Nueva inscripción ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
        <a href="../disciplina/listar.php">[ Disciplinas ]</a>
    </nav>
</header>

<main>

    <h2>Realizar inscripción</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="id_estudiante">Estudiante <span class="requerido">*</span></label>
        <select name="id_estudiante" id="id_estudiante" required>
            <option value="">Seleccione un estudiante</option>
            <?php foreach ($estudiantes as $estudiante) { ?>
                <option value="<?= $estudiante['id_estudiante'] ?>">
                    <?= htmlspecialchars($estudiante['apellido'] . ", " . $estudiante['nombre'] . " (DNI: " . $estudiante['dni'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_disciplina">Disciplina <span class="requerido">*</span></label>
        <select name="id_disciplina" id="id_disciplina" required>
            <option value="">Seleccione una disciplina</option>
            <?php foreach ($disciplinas as $disciplina) { ?>
                <option value="<?= $disciplina['id_disciplina'] ?>">
                    <?= htmlspecialchars($disciplina['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha_inscripcion">Fecha de inscripción <span class="requerido">*</span></label>
        <input type="date" name="fecha_inscripcion" id="fecha_inscripcion" required
               value="<?= date('Y-m-d') ?>">

        <label for="anio_participacion">Año de participación <span class="requerido">*</span></label>
        <input type="number" name="anio_participacion" id="anio_participacion" min="2020" max="2030" required
               value="<?= htmlspecialchars($_POST['anio_participacion'] ?? date('Y')) ?>">

        <label for="estado">Estado <span class="requerido">*</span></label>
        <select name="estado" id="estado" required>
            <option value="pendiente">Pendiente</option>
            <option value="confirmada">Confirmada</option>
            <option value="cancelada">Cancelada</option>
        </select>

        <button type="submit">Registrar inscripción</button>

    </form>

    <p><a href="listar.php">Volver al listado de inscripciones</a></p>

</main>

</body>
</html>