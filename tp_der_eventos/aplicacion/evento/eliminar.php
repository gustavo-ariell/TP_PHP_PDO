<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_evento"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        $stmt_ee = $pdo->prepare("DELETE FROM evento_expositor WHERE id_evento = :id_evento");
        $stmt_ee->execute([':id_evento' => $id]);

        $stmt_ins = $pdo->prepare("DELETE FROM inscripcion_evento WHERE id_evento = :id_evento");
        $stmt_ins->execute([':id_evento' => $id]);

        $stmt_ev = $pdo->prepare("DELETE FROM evento WHERE id_evento = :id_evento");
        $stmt_ev->execute([':id_evento' => $id]);

        $mensaje = "Evento eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el evento.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre, fecha FROM evento WHERE id_evento = :id_evento";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_evento' => $id]);
$evento = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar evento</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Eventos ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar evento</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($evento && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar el evento
           <strong><?= htmlspecialchars($evento['nombre']) ?></strong>
           del <strong><?= htmlspecialchars($evento['fecha']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_evento" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de eventos</a></p>

    <?php } ?>

</main>

</body>
</html>