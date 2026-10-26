<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_vendedor"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM vendedor WHERE id_vendedor = :id_vendedor";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_vendedor' => $id]);

        $mensaje = "Vendedor eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el vendedor. Puede tener ventas asociadas.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre, apellido FROM vendedor WHERE id_vendedor = :id_vendedor";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_vendedor' => $id]);
$vendedor = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar vendedor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE VENTAS DE LIBRERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Vendedores ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar vendedor</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($vendedor && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar al vendedor
           <strong><?= htmlspecialchars($vendedor['nombre'] . " " . $vendedor['apellido']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_vendedor" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de vendedores</a></p>

    <?php } ?>

</main>

</body>
</html>