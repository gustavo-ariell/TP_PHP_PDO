<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_asistente = $_POST["id_asistente"] ?? "";
    $id_evento = $_POST["id_evento"] ?? "";
    $fecha_inscripcion = $_POST["fecha_inscripcion"] ?? "";

    if ($id_asistente === "" || $id_evento === "" || $fecha_inscripcion === "") {
        $mensaje = "Debe seleccionar un asistente, un evento e ingresar la fecha de inscripción.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO inscripcion_evento (id_asistente, id_evento, fecha_inscripcion)
                VALUES (:id_asistente, :id_evento, :fecha_inscripcion)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_asistente'      => (int)$id_asistente,
                ':id_evento'         => (int)$id_evento,
                ':fecha_inscripcion' => $fecha_inscripcion
            ]);

            $mensaje = "Inscripción realizada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo realizar la inscripción.";
            $tipo_mensaje = "error";
        }
    }
}

$asistentes = $pdo->query("SELECT id_asistente, nombre, apellido, dni FROM asistente ORDER BY apellido")->fetchAll();
$eventos = $pdo->query("SELECT id_evento, nombre, fecha FROM evento ORDER BY fecha DESC")->fetchAll();
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
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Inscripciones ]</a>
        <a href="alta.php">[ Nueva inscripción ]</a>
        <a href="../asistente/listar.php">[ Asistentes ]</a>
        <a href="../evento/listar.php">[ Eventos ]</a>
    </nav>
</header>

<main>

    <h2>Realizar inscripción</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="id_asistente">Asistente <span class="requerido">*</span></label>
        <select name="id_asistente" id="id_asistente" required>
            <option value="">Seleccione un asistente</option>
            <?php foreach ($asistentes as $asistente) { ?>
                <option value="<?= $asistente['id_asistente'] ?>">
                    <?= htmlspecialchars($asistente['apellido'] . ", " . $asistente['nombre'] . " (DNI: " . $asistente['dni'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_evento">Evento <span class="requerido">*</span></label>
        <select name="id_evento" id="id_evento" required>
            <option value="">Seleccione un evento</option>
            <?php foreach ($eventos as $evento) { ?>
                <option value="<?= $evento['id_evento'] ?>">
                    <?= htmlspecialchars($evento['nombre'] . " (" . $evento['fecha'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha_inscripcion">Fecha de inscripción <span class="requerido">*</span></label>
        <input type="date" name="fecha_inscripcion" id="fecha_inscripcion" required
               value="<?= date('Y-m-d') ?>">

        <button type="submit">Realizar inscripción</button>

    </form>

    <p><a href="listar.php">Volver al listado de inscripciones</a></p>

</main>

</body>
</html>