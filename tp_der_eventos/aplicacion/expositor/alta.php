<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $tema_exposicion = trim($_POST["tema_exposicion"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if ($nombre === "" || $apellido === "") {
        $mensaje = "Debe ingresar un nombre y un apellido.";
        $tipo_mensaje = "error";
    } elseif ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Debe ingresar un correo electrónico válido.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO expositor (nombre, apellido, tema_exposicion, email)
                VALUES (:nombre, :apellido, :tema_exposicion, :email)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'          => $nombre,
                ':apellido'        => $apellido,
                ':tema_exposicion' => $tema_exposicion,
                ':email'           => $email
            ]);

            $mensaje = "Expositor registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el expositor.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar expositor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Expositores ]</a>
        <a href="alta.php">[ Nuevo expositor ]</a>
        <a href="../evento/listar.php">[ Eventos ]</a>
        <a href="../asistente/listar.php">[ Asistentes ]</a>
    </nav>
</header>

<main>

    <h2>Registrar expositor</h2>

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

        <label for="tema_exposicion">Tema de exposición</label>
        <input type="text" name="tema_exposicion" id="tema_exposicion"
               value="<?= htmlspecialchars($_POST['tema_exposicion'] ?? '') ?>">

        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <button type="submit">Registrar expositor</button>

    </form>

    <p><a href="listar.php">Volver al listado de expositores</a></p>

</main>

</body>
</html>