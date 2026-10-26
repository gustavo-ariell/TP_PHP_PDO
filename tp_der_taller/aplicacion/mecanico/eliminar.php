<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_mecanico"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM mecanico WHERE id_mecanico = :id_mecanico";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_mecanico' => $id]);

        $mensaje = "Mecánico eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el mecánico. Puede tener reparaciones asociadas.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre, apellido FROM mecanico WHERE id_mecanico = :id_mecanico";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_mecanico' => $id]);
$mecanico = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar mecánico</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Mecánicos ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar mecánico</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($mecanico && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar al mecánico
           <strong><?= htmlspecialchars($mecanico['nombre'] . " " . $mecanico['apellido']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_mecanico" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de mecánicos</a></p>

    <?php } ?>

</main>

</body>
</html>