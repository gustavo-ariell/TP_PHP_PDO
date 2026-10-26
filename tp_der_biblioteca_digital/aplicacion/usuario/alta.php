<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $fecha_registro = $_POST["fecha_registro"] ?? "";

    if ($nombre === "" || $apellido === "" || $email === "" || $fecha_registro === "") {
        $mensaje = "Debe completar todos los campos obligatorios.";
        $tipo_mensaje = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Debe ingresar un correo electrónico válido.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO usuario (nombre, apellido, email, fecha_registro)
                VALUES (:nombre, :apellido, :email, :fecha_registro)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'         => $nombre,
                ':apellido'       => $apellido,
                ':email'          => $email,
                ':fecha_registro' => $fecha_registro
            ]);

            $mensaje = "Usuario registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el usuario. El correo ya existe.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar usuario</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Usuarios ]</a>
        <a href="alta.php">[ Nuevo usuario ]</a>
        <a href="../libro/listar.php">[ Libros ]</a>
        <a href="../descarga/listar.php">[ Descargas ]</a>
    </nav>
</header>

<main>

    <h2>Registrar usuario</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <label for="apellido">Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" id="apellido" required
               value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>">

        <label for="email">Correo electrónico <span class="requerido">*</span></label>
        <input type="email" name="email" id="email" required
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <label for="fecha_registro">Fecha de registro <span class="requerido">*</span></label>
        <input type="date" name="fecha_registro" id="fecha_registro" required
               value="<?= htmlspecialchars($_POST['fecha_registro'] ?? date('Y-m-d')) ?>">

        <button type="submit">Registrar usuario</button>

    </form>

    <p><a href="listar.php">Volver al listado de usuarios</a></p>

</main>

</body>
</html>