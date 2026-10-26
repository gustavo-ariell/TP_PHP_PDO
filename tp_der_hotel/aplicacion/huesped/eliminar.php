<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_huesped"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM huesped WHERE id_huesped = :id_huesped";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_huesped' => $id]);

        $mensaje = "Huésped eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el huésped. Puede tener reservas asociadas.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre, apellido FROM huesped WHERE id_huesped = :id_huesped";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_huesped' => $id]);
$huesped = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar huésped</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Huéspedes ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar huésped</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($huesped && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar al huésped
           <strong><?= htmlspecialchars($huesped['nombre'] . " " . $huesped['apellido']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_huesped" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de huéspedes</a></p>

    <?php } ?>

</main>

</body>
</html>