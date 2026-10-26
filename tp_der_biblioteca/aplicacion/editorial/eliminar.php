<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_editorial"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM editorial WHERE id_editorial = :id_editorial";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_editorial' => $id]);

        $mensaje = "Editorial eliminada correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar la editorial. Puede tener libros asociados.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre FROM editorial WHERE id_editorial = :id_editorial";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_editorial' => $id]);
$editorial = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar editorial</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Editoriales ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar editorial</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($editorial && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar la editorial
           <strong><?= htmlspecialchars($editorial['nombre']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_editorial" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de editoriales</a></p>

    <?php } ?>

</main>

</body>
</html>