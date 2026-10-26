<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_categoria = (int)($_POST["id_categoria"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");

    if ($nombre === "") {
        $mensaje = "Debe ingresar el nombre de la categoría.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE categoria SET nombre = :nombre WHERE id_categoria = :id_categoria";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'       => $nombre,
                ':id_categoria' => $id_categoria
            ]);

            $mensaje = "Categoría modificada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar la categoría.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_categoria"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_categoria, nombre FROM categoria WHERE id_categoria = :id_categoria";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_categoria' => $id]);
$categoria = $stmt->fetch();

if (!$categoria) {
    die("La categoría solicitada no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar categoría</title>
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

    <h2>Modificar categoría</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_categoria" value="<?= $categoria['id_categoria'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($categoria['nombre']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>