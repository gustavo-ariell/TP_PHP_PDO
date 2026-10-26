<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_categoria"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM categoria WHERE id_categoria = :id_categoria";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_categoria' => $id]);

        $mensaje = "Categoría eliminada correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar la categoría. Puede tener libros asociados.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre FROM categoria WHERE id_categoria = :id_categoria";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_categoria' => $id]);
$categoria = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar categoría</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Categorías ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar categoría</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($categoria && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar la categoría
           <strong><?= htmlspecialchars($categoria['nombre']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_categoria" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de categorías</a></p>

    <?php } ?>

</main>

</body>
</html>