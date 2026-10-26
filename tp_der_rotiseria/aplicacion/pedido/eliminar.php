<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_pedido"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        $stmt_dp = $pdo->prepare("DELETE FROM detalle_pedido WHERE id_pedido = :id_pedido");
        $stmt_dp->execute([':id_pedido' => $id]);

        $stmt_ped = $pdo->prepare("DELETE FROM pedido WHERE id_pedido = :id_pedido");
        $stmt_ped->execute([':id_pedido' => $id]);

        $mensaje = "Pedido eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el pedido.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT
            p.fecha,
            p.estado,
            c.nombre AS nombre_cliente,
            c.apellido AS apellido_cliente
        FROM pedido p
        INNER JOIN cliente c ON p.id_cliente = c.id_cliente
        WHERE p.id_pedido = :id_pedido";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_pedido' => $id]);
$ped = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar pedido</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PEDIDOS — ROTISERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Pedidos ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar pedido</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($ped && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar el pedido de
           <strong><?= htmlspecialchars($ped['nombre_cliente'] . " " . $ped['apellido_cliente']) ?></strong>
           del <strong><?= htmlspecialchars($ped['fecha']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_pedido" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de pedidos</a></p>

    <?php } ?>

</main>

</body>
</html>