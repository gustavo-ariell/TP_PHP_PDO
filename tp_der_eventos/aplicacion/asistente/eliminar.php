<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_asistente"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        $stmt_ins = $pdo->prepare("DELETE FROM inscripcion_evento WHERE id_asistente = :id_asistente");
        $stmt_ins->execute([':id_asistente' => $id]);

        $stmt = $pdo->prepare("DELETE FROM asistente WHERE id_asistente = :id_asistente");
        $stmt->execute([':id_asistente' => $id]);

        $mensaje = "Asistente eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el asistente.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre, apellido FROM asistente WHERE id_asistente = :id_asistente";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_asistente' => $id]);
$asistente = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar asistente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Asistentes ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar asistente</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($asistente && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar al asistente
           <strong><?= htmlspecialchars($asistente['nombre'] . " " . $asistente['apellido']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_asistente" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de asistentes</a></p>

    <?php } ?>

</main>

</body>
</html>