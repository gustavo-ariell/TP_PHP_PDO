<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_vehiculo"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM vehiculo WHERE id_vehiculo = :id_vehiculo";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_vehiculo' => $id]);

        $mensaje = "Vehículo eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el vehículo. Puede tener reparaciones asociadas.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT patente, marca, modelo FROM vehiculo WHERE id_vehiculo = :id_vehiculo";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_vehiculo' => $id]);
$vehiculo = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar vehículo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Vehículos ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar vehículo</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($vehiculo && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar el vehículo
           <strong><?= htmlspecialchars($vehiculo['patente'] . " (" . $vehiculo['marca'] . " " . $vehiculo['modelo'] . ")") ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_vehiculo" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de vehículos</a></p>

    <?php } ?>

</main>

</body>
</html>