<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_servicio"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM servicio WHERE id_servicio = :id_servicio";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_servicio' => $id]);

        $mensaje = "Servicio eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el servicio. Puede estar asociado a una reparación.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre FROM servicio WHERE id_servicio = :id_servicio";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_servicio' => $id]);
$servicio = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar servicio</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Servicios ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar servicio</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($servicio && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar el servicio
           <strong><?= htmlspecialchars($servicio['nombre']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_servicio" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de servicios</a></p>

    <?php } ?>

</main>

</body>
</html>