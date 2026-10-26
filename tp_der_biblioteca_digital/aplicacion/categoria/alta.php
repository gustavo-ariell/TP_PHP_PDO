<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");

    if ($nombre === "") {
        $mensaje = "Debe ingresar el nombre de la categoría.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO categoria (nombre) VALUES (:nombre)";

        try {

            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nombre' => $nombre]);

            $mensaje = "Categoría registrada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar la categoría.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar categoría</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Categorías ]</a>
        <a href="alta.php">[ Nueva categoría ]</a>
        <a href="../libro/listar.php">[ Libros ]</a>
    </nav>
</header>

<main>

    <h2>Registrar categoría</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <button type="submit">Registrar categoría</button>

    </form>

    <p><a href="listar.php">Volver al listado de categorías</a></p>

</main>

</body>
</html>