<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_proveedor"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        $stmt_pp = $pdo->prepare("DELETE FROM producto_proveedor WHERE id_proveedor = :id_proveedor");
        $stmt_pp->execute([':id_proveedor' => $id]);

        $stmt_prov = $pdo->prepare("DELETE FROM proveedor WHERE id_proveedor = :id_proveedor");
        $stmt_prov->execute([':id_proveedor' => $id]);

        $mensaje = "Proveedor eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el proveedor.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre FROM proveedor WHERE id_proveedor = :id_proveedor";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_proveedor' => $id]);
$proveedor = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar proveedor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE INVENTARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Proveedores ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar proveedor</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($proveedor && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar al proveedor
           <strong><?= htmlspecialchars($proveedor['nombre']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_proveedor" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de proveedores</a></p>

    <?php } ?>

</main>

</body>
</html>