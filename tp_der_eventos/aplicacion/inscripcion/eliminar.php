<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_inscripcion"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM inscripcion_evento WHERE id_inscripcion = :id_inscripcion";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_inscripcion' => $id]);

        $mensaje = "Inscripción eliminada correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar la inscripción.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT
            i.fecha_inscripcion,
            a.nombre AS nombre_asistente,
            a.apellido AS apellido_asistente,
            e.nombre AS evento
        FROM inscripcion_evento i
        INNER JOIN asistente a ON i.id_asistente = a.id_asistente
        INNER JOIN evento e ON i.id_evento = e.id_evento
        WHERE i.id_inscripcion = :id_inscripcion";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_inscripcion' => $id]);
$inscripcion = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar inscripción</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Inscripciones ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar inscripción</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($inscripcion && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar la inscripción de
           <strong><?= htmlspecialchars($inscripcion['nombre_asistente'] . " " . $inscripcion['apellido_asistente']) ?></strong>
           al evento <strong><?= htmlspecialchars($inscripcion['evento']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_inscripcion" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de inscripciones</a></p>

    <?php } ?>

</main>

</body>
</html>