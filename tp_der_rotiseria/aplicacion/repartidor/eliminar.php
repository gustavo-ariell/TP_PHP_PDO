<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_repartidor"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        $stmt_ped = $pdo->prepare("UPDATE pedido SET id_repartidor = NULL WHERE id_repartidor = :id_repartidor");
        $stmt_ped->execute([':id_repartidor' => $id]);

        $stmt = $pdo->prepare("DELETE FROM repartidor WHERE id_repartidor = :id_repartidor");
        $stmt->execute([':id_repartidor' => $id]);

        $mensaje = "Repartidor eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el repartidor.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre, apellido FROM repartidor WHERE id_repartidor = :id_repartidor";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_repartidor' => $id]);
$repartidor = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar repartidor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PEDIDOS — ROTISERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Repartidores ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar repartidor</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($repartidor && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar al repartidor
           <strong><?= htmlspecialchars($repartidor['nombre'] . " " . $repartidor['apellido']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_repartidor" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de repartidores</a></p>

    <?php } ?>

</main>

</body>
</html>