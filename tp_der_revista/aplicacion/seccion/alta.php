<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre      = trim($_POST["nombre"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");

    if ($nombre === "") {
        $mensaje = "Debe ingresar el nombre de la sección.";
        $tipo_mensaje = "error";
    } else {

        try {

            $stmt = $pdo->prepare("INSERT INTO seccion (nombre, descripcion) VALUES (:nombre, :descripcion)");
            $stmt->execute([
                ':nombre'      => $nombre,
                ':descripcion' => $descripcion
            ]);

            $mensaje = "Sección registrada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar la sección.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar sección</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>REGISTRAR SECCIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar secciones ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <h2>Nueva sección</h2>

    <form action="alta.php" method="POST">

        <label>Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <label>Descripción</label>
        <textarea name="descripcion" rows="3"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>

        <button type="submit">Registrar</button>

    </form>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>