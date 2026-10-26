<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_tipo"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM tipo_evento WHERE id_tipo = :id_tipo";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_tipo' => $id]);

        $mensaje = "Tipo de evento eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el tipo. Puede tener eventos asociados.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre FROM tipo_evento WHERE id_tipo = :id_tipo";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_tipo' => $id]);
$tipo = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar tipo de evento</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Tipos ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar tipo de evento</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($tipo && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar el tipo
           <strong><?= htmlspecialchars($tipo['nombre']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_tipo" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de tipos</a></p>

    <?php } ?>

</main>

</body>
</html>