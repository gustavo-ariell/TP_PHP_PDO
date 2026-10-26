<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_expositor"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        $stmt_ee = $pdo->prepare("DELETE FROM evento_expositor WHERE id_expositor = :id_expositor");
        $stmt_ee->execute([':id_expositor' => $id]);

        $stmt = $pdo->prepare("DELETE FROM expositor WHERE id_expositor = :id_expositor");
        $stmt->execute([':id_expositor' => $id]);

        $mensaje = "Expositor eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el expositor.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre, apellido FROM expositor WHERE id_expositor = :id_expositor";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_expositor' => $id]);
$expositor = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar expositor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Expositores ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar expositor</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($expositor && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar al expositor
           <strong><?= htmlspecialchars($expositor['nombre'] . " " . $expositor['apellido']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_expositor" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de expositores</a></p>

    <?php } ?>

</main>

</body>
</html>