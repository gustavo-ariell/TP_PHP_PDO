<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_autor"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM autor WHERE id_autor = :id_autor";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_autor' => $id]);

        $mensaje = "Autor eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el autor. Puede tener libros asociados.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre, apellido FROM autor WHERE id_autor = :id_autor";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_autor' => $id]);
$autor = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar autor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Autores ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar autor</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($autor && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar al autor
           <strong><?= htmlspecialchars($autor['nombre'] . " " . $autor['apellido']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_autor" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de autores</a></p>

    <?php } ?>

</main>

</body>
</html>