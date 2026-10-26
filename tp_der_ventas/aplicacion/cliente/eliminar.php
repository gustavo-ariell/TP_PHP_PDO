<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_cliente"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM cliente WHERE id_cliente = :id_cliente";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_cliente' => $id]);

        $mensaje = "Cliente eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el cliente. Puede tener ventas asociadas.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre, apellido FROM cliente WHERE id_cliente = :id_cliente";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_cliente' => $id]);
$cliente = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar cliente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE VENTAS DE LIBRERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Clientes ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar cliente</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($cliente && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar al cliente
           <strong><?= htmlspecialchars($cliente['nombre'] . " " . $cliente['apellido']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_cliente" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de clientes</a></p>

    <?php } ?>

</main>

</body>
</html>