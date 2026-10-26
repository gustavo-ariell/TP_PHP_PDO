<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_reserva"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM reserva WHERE id_reserva = :id_reserva";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_reserva' => $id]);

        $mensaje = "Reserva eliminada correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar la reserva.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT
            r.fecha,
            r.estado,
            e.nombre AS nombre_estudiante,
            e.apellido AS apellido_estudiante,
            m.fecha AS fecha_menu
        FROM reserva r
        INNER JOIN estudiante e ON r.id_estudiante = e.id_estudiante
        INNER JOIN menu m ON r.id_menu = m.id_menu
        WHERE r.id_reserva = :id_reserva";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_reserva' => $id]);
$reserva = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar reserva</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE COMEDOR UNIVERSITARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Reservas ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar reserva</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($reserva && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar la reserva de
           <strong><?= htmlspecialchars($reserva['nombre_estudiante'] . " " . $reserva['apellido_estudiante']) ?></strong>
           para el menú del
           <strong><?= htmlspecialchars($reserva['fecha_menu']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_reserva" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de reservas</a></p>

    <?php } ?>

</main>

</body>
</html>