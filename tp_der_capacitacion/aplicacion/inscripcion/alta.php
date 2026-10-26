<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_estudiante = $_POST["id_estudiante"] ?? "";
    $id_curso = $_POST["id_curso"] ?? "";
    $fecha_inscripcion = $_POST["fecha_inscripcion"] ?? "";
    $estado = $_POST["estado"] ?? "";
    $calificacion = trim($_POST["calificacion_final"] ?? "");

    if ($id_estudiante === "" || $id_curso === "" || $fecha_inscripcion === "") {
        $mensaje = "Debe seleccionar un estudiante, un curso e ingresar la fecha de inscripción.";
        $tipo_mensaje = "error";
    } elseif (!in_array($estado, ["activa", "finalizada", "cancelada"])) {
        $mensaje = "El estado debe ser activa, finalizada o cancelada.";
        $tipo_mensaje = "error";
    } elseif ($calificacion !== "" && (!is_numeric($calificacion) || (float)$calificacion < 0 || (float)$calificacion > 10)) {
        $mensaje = "La calificación debe ser un número entre 0 y 10.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO inscripcion (id_estudiante, id_curso, fecha_inscripcion, estado, calificacion_final)
                VALUES (:id_estudiante, :id_curso, :fecha_inscripcion, :estado, :calificacion_final)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_estudiante'     => (int)$id_estudiante,
                ':id_curso'          => (int)$id_curso,
                ':fecha_inscripcion' => $fecha_inscripcion,
                ':estado'            => $estado,
                ':calificacion_final' => ($calificacion === "" ? null : (float)$calificacion)
            ]);

            $mensaje = "Inscripción realizada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo realizar la inscripción.";
            $tipo_mensaje = "error";
        }
    }
}

$estudiantes = $pdo->query("SELECT id_estudiante, nombre, apellido, dni FROM estudiante ORDER BY apellido")->fetchAll();
$cursos = $pdo->query("SELECT id_curso, nombre FROM curso ORDER BY nombre")->fetchAll();
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
    <h1>SISTEMA DE GESTIÓN DE CURSOS DE CAPACITACIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Inscripciones ]</a>
        <a href="alta.php">[ Nueva inscripción ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
        <a href="../curso/listar.php">[ Cursos ]</a>
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

        <label for="id_curso">Curso <span class="requerido">*</span></label>
        <select name="id_curso" id="id_curso" required>
            <option value="">Seleccione un curso</option>
            <?php foreach ($cursos as $curso) { ?>
                <option value="<?= $curso['id_curso'] ?>">
                    <?= htmlspecialchars($curso['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha_inscripcion">Fecha de inscripción <span class="requerido">*</span></label>
        <input type="date" name="fecha_inscripcion" id="fecha_inscripcion" required
               value="<?= date('Y-m-d') ?>">

        <label for="estado">Estado <span class="requerido">*</span></label>
        <select name="estado" id="estado" required>
            <option value="activa">Activa</option>
            <option value="finalizada">Finalizada</option>
            <option value="cancelada">Cancelada</option>
        </select>

        <label for="calificacion_final">Calificación final</label>
        <input type="number" name="calificacion_final" id="calificacion_final" step="0.01" min="0" max="10"
               value="<?= htmlspecialchars($_POST['calificacion_final'] ?? '') ?>">

        <button type="submit">Realizar inscripción</button>

    </form>

    <p><a href="listar.php">Volver al listado de inscripciones</a></p>

</main>

</body>
</html>