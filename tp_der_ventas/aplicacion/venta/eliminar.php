<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_venta"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        $stmt_det = $pdo->prepare("DELETE FROM detalle_venta WHERE id_venta = :id_venta");
        $stmt_det->execute([':id_venta' => $id]);

        $stmt_ven = $pdo->prepare("DELETE FROM venta WHERE id_venta = :id_venta");
        $stmt_ven->execute([':id_venta' => $id]);

        $mensaje = "Venta eliminada correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar la venta.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT
            v.fecha,
            v.total,
            c.nombre AS nombre_cliente,
            c.apellido AS apellido_cliente
        FROM venta v
        INNER JOIN cliente c ON v.id_cliente = c.id_cliente
        WHERE v.id_venta = :id_venta";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_venta' => $id]);
$venta = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar venta</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE VENTAS DE LIBRERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Ventas ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar venta</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($venta && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar la venta del cliente
           <strong><?= htmlspecialchars($venta['nombre_cliente'] . " " . $venta['apellido_cliente']) ?></strong>
           del día <strong><?= htmlspecialchars($venta['fecha']) ?></strong>
           por <strong>$<?= number_format((float)$venta['total'], 2, ',', '.') ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_venta" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de ventas</a></p>

    <?php } ?>

</main>

</body>
</html>