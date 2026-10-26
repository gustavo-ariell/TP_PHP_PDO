<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje =_categoria'] == $producto['id_categoria'] ? "selected" : "" "";
$id = (int)($_GET["id"] ?? $_POST["id_producto"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        $stmt_dp = $pdo->prepare("DELETE FROM detalle_pedido WHERE id_producto = :id_producto");
        $stmt_dp->execute([':id_producto' => $id]);

        $stmt = $pdo->prepare("DELETE FROM producto WHERE id_producto = :id_producto");
        $stmt->execute([':id_producto' => $id]);

        $mensaje = "Producto eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el producto.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre FROM producto WHERE id_producto = :id_producto";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_producto' => $id]);
$producto = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar producto</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PEDIDOS — ROTISERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Productos ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar producto</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($producto && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar el producto
           <strong><?= htmlspecialchars($producto['nombre']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_producto" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de productos</a></p>

    <?php } ?>

</main>

</body>
</html>