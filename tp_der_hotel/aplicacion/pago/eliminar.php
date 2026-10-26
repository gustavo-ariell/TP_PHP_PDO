<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_pago"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM pago WHERE id_pago = :id_pago";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_pago' => $id]);

        $mensaje = "Pago eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el pago.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT
            p.fecha_pago,
            p.monto,
            p.metodo_pago,
            h.nombre AS nombre_huesped,
            h.apellido AS apellido_huesped
        FROM pago p
        INNER JOIN reserva r ON p.id_reserva = r.id_reserva
        INNER JOIN huesped h ON r.id_huesped = h.id_huesped
        WHERE p.id_pago = :id_pago";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_pago' => $id]);
$pago = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar pago</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Pagos ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar pago</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($pago && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar el pago de
           <strong><?= htmlspecialchars($pago['nombre_huesped'] . " " . $pago['apellido_huesped']) ?></strong>
           por <strong>$<?= number_format((float)$pago['monto'], 2, ',', '.') ?></strong>
           del día <strong><?= htmlspecialchars($pago['fecha_pago']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_pago" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de pagos</a></p>

    <?php } ?>

</main>

</body>
</html>