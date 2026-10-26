<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_reserva"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        $stmt_pagos = $pdo->prepare("DELETE FROM pago WHERE id_reserva = :id_reserva");
        $stmt_pagos->execute([':id_reserva' => $id]);

        $stmt_reserva = $pdo->prepare("DELETE FROM reserva WHERE id_reserva = :id_reserva");
        $stmt_reserva->execute([':id_reserva' => $id]);

        $mensaje = "Reserva eliminada correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar la reserva.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT
            r.fecha_ingreso,
            r.fecha_salida,
            r.estado,
            h.nombre AS nombre_huesped,
            h.apellido AS apellido_huesped,
            hab.numero AS habitacion
        FROM reserva r
        INNER JOIN huesped h ON r.id_huesped = h.id_huesped
        INNER JOIN habitacion hab ON r.id_habitacion = hab.id_habitacion
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
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
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
           <strong><?= htmlspecialchars($reserva['nombre_huesped'] . " " . $reserva['apellido_huesped']) ?></strong>
           en la habitación <strong><?= htmlspecialchars($reserva['habitacion']) ?></strong>
           del <strong><?= htmlspecialchars($reserva['fecha_ingreso']) ?></strong>
           al <strong><?= htmlspecialchars($reserva['fecha_salida']) ?></strong>?</p>

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