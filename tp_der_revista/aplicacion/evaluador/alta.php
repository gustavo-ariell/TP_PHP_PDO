<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre       = trim($_POST["nombre"] ?? "");
    $apellido     = trim($_POST["apellido"] ?? "");
    $email        = trim($_POST["email"] ?? "");
    $especialidad = trim($_POST["especialidad"] ?? "");

    if ($nombre === "" || $apellido === "") {
        $mensaje = "Debe ingresar nombre y apellido.";
        $tipo_mensaje = "error";
    } elseif ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo electrónico no tiene un formato válido.";
        $tipo_mensaje = "error";
    } else {

        try {

            $stmt = $pdo->prepare("INSERT INTO evaluador (nombre, apellido, email, especialidad)
                                   VALUES (:nombre, :apellido, :email, :especialidad)");
            $stmt->execute([
                ':nombre'       => $nombre,
                ':apellido'     => $apellido,
                ':email'        => $email,
                ':especialidad' => $especialidad
            ]);

            $mensaje = "Evaluador registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el evaluador.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar evaluador</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>REGISTRAR EVALUADOR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar evaluadores ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <h2>Nuevo evaluador</h2>

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

        <label>Especialidad</label>
        <input type="text" name="especialidad"
               value="<?= htmlspecialchars($_POST['especialidad'] ?? '') ?>">

        <button type="submit">Registrar</button>

    </form>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>