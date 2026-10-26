<?php
require_once "../conexion.php";

$mensaje = "";
$error   = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");

    if ($nombre === "") {
        $error = "Debe ingresar el nombre del instrumento.";
    } else {

        try {

            $stmt = $pdo->prepare("INSERT INTO instrumento (nombre) VALUES (:nombre)");
            $stmt->execute([":nombre" => $nombre]);

            $mensaje = "Instrumento registrado correctamente.";

        } catch (PDOException $e) {
            $error = "No se pudo registrar el instrumento.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar instrumento</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>REGISTRAR INSTRUMENTO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar instrumentos ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje exito"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <?php if ($error !== ""): ?>
        <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <h2>Nuevo instrumento</h2>

    <form action="alta.php" method="POST">
        <label>Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" required>

        <button type="submit">Registrar</button>
    </form>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>