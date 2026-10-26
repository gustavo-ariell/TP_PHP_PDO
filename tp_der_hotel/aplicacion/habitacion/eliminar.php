<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_habitacion"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM habitacion WHERE id_habitacion = :id_habitacion";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_habitacion' => $id]);

        $mensaje = "Habitación eliminada correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar la habitación. Puede tener reservas asociadas.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT numero FROM habitacion WHERE id_habitacion = :id_habitacion";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_habitacion' => $id]);
$habitacion = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar habitación</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Habitaciones ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar habitación</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($habitacion && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar la habitación
           <strong><?= htmlspecialchars($habitacion['numero']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_habitacion" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de habitaciones</a></p>

    <?php } ?>

</main>

</body>
</html>