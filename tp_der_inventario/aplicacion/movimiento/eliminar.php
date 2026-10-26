<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_movimiento"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        // Primero obtenemos los datos para revertir el stock
        $sql_data = "SELECT id_producto, tipo, cantidad FROM movimiento_stock WHERE id_movimiento = :id_movimiento";
        $stmt_data = $pdo->prepare($sql_data);
        $stmt_data->execute([':id_movimiento' => $id]);
        $mov_data = $stmt_data->fetch();

        if ($mov_data) {

            // Revertir el stock
            if ($mov_data['tipo'] === "entrada") {
                $sql_revert = "UPDATE producto SET stock_actual = stock_actual - :cantidad WHERE id_producto = :id_producto";
            } else {
                $sql_revert = "UPDATE producto SET stock_actual = stock_actual + :cantidad WHERE id_producto = :id_producto";
            }

            $stmt_revert = $pdo->prepare($sql_revert);
            $stmt_revert->execute([
                ':cantidad'    => (int)$mov_data['cantidad'],
                ':id_producto' => (int)$mov_data['id_producto']
            ]);
        }

        $sql = "DELETE FROM movimiento_stock WHERE id_movimiento = :id_movimiento";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_movimiento' => $id]);

        $mensaje = "Movimiento eliminado y stock revertido correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el movimiento.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT
            m.tipo,
            m.fecha,
            m.cantidad,
            p.nombre AS producto
        FROM movimiento_stock m
        INNER JOIN producto p ON m.id_producto = p.id_producto
        WHERE m.id_movimiento = :id_movimiento";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_movimiento' => $id]);
$mov = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar movimiento</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE INVENTARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Movimientos ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar movimiento</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($mov && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar el movimiento de
           <strong><?= htmlspecialchars($mov['tipo']) ?></strong>
           de <strong><?= (int)$mov['cantidad'] ?></strong> unidades de
           <strong><?= htmlspecialchars($mov['producto']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_movimiento" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de movimientos</a></p>

    <?php } ?>

</main>

</body>
</html>