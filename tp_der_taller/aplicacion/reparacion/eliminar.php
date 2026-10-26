<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_reparacion"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        $stmt_rs = $pdo->prepare("DELETE FROM reparacion_servicio WHERE id_reparacion = :id_reparacion");
        $stmt_rs->execute([':id_reparacion' => $id]);

        $stmt_rep = $pdo->prepare("DELETE FROM reparacion WHERE id_reparacion = :id_reparacion");
        $stmt_rep->execute([':id_reparacion' => $id]);

        $mensaje = "Reparación eliminada correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar la reparación.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT
            r.fecha_ingreso,
            r.estado,
            v.patente,
            v.marca,
            v.modelo
        FROM reparacion r
        INNER JOIN vehiculo v ON r.id_vehiculo = v.id_vehiculo
        WHERE r.id_reparacion = :id_reparacion";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_reparacion' => $id]);
$rep = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar reparación</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Reparaciones ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar reparación</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($rep && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar la reparación del vehículo
           <strong><?= htmlspecialchars($rep['patente'] . " (" . $rep['marca'] . " " . $rep['modelo'] . ")") ?></strong>
           con fecha de ingreso <strong><?= htmlspecialchars($rep['fecha_ingreso']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_reparacion" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de reparaciones</a></p>

    <?php } ?>

</main>

</body>
</html>