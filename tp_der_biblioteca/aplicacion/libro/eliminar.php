<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_libro"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM libro WHERE id_libro = :id_libro";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_libro' => $id]);

        $mensaje = "Libro eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el libro. Puede tener préstamos asociados.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT titulo FROM libro WHERE id_libro = :id_libro";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_libro' => $id]);
$libro = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar libro</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Libros ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar libro</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($libro && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar el libro
           <strong><?= htmlspecialchars($libro['titulo']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_libro" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de libros</a></p>

    <?php } ?>

</main>

</body>
</html>