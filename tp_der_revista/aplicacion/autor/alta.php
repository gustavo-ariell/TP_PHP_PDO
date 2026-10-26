<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre      = trim($_POST["nombre"] ?? "");
    $apellido    = trim($_POST["apellido"] ?? "");
    $email       = trim($_POST["email"] ?? "");
    $institucion = trim($_POST["institucion"] ?? "");

    if ($nombre === "" || $apellido === "") {
        $mensaje = "Debe ingresar nombre y apellido.";
        $tipo_mensaje = "error";
    } elseif ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo electrónico no tiene un formato válido.";
        $tipo_mensaje = "error";
    } else {

        try {

            $stmt = $pdo->prepare("INSERT INTO autor (nombre, apellido, email, institucion)
                                   VALUES (:nombre, :apellido, :email, :institucion)");
            $stmt->execute([
                ':nombre'      => $nombre,
                ':apellido'    => $apellido,
                ':email'       => $email,
                ':institucion' => $institucion
            ]);

            $mensaje = "Autor registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el autor.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar autor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>REGISTRAR AUTOR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar autores ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <h2>Nuevo autor</h2>

    <form action="alta.php" method="POST">

        <label>Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <label>Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" required
               value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>">

        <label>Email</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <label>Institución</label>
        <input type="text" name="institucion"
               value="<?= htmlspecialchars($_POST['institucion'] ?? '') ?>">

        <button type="submit">Registrar</button>

    </form>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>