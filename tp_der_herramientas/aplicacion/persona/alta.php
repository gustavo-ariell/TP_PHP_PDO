<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre      = trim($_POST["nombre"] ?? "");
    $apellido    = trim($_POST["apellido"] ?? "");
    $dni         = trim($_POST["dni"] ?? "");
    $tipo_persona = $_POST["tipo_persona"] ?? "";
    $telefono    = trim($_POST["telefono"] ?? "");
    $email       = trim($_POST["email"] ?? "");

    $tiposValidos = ["docente", "estudiante", "personal_administrativo"];

    if ($nombre === "" || $apellido === "" || $dni === "") {
        $mensaje = "Debe ingresar nombre, apellido y DNI.";
        $tipo_mensaje = "error";
    } elseif (!ctype_digit($dni)) {
        $mensaje = "El DNI debe contener solo números.";
        $tipo_mensaje = "error";
    } elseif (!in_array($tipo_persona, $tiposValidos)) {
        $mensaje = "Debe seleccionar un tipo de persona válido.";
        $tipo_mensaje = "error";
    } elseif ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo electrónico no tiene un formato válido.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO persona (nombre, apellido, dni, tipo_persona, telefono, email)
                VALUES (:nombre, :apellido, :dni, :tipo_persona, :telefono, :email)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'      => $nombre,
                ':apellido'    => $apellido,
                ':dni'         => $dni,
                ':tipo_persona'=> $tipo_persona,
                ':telefono'    => $telefono,
                ':email'       => $email
            ]);

            $mensaje = "Persona registrada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar. Verifique que el DNI no esté repetido.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar persona</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>REGISTRAR PERSONA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar personas ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <h2>Nueva persona</h2>

    <form action="alta.php" method="POST">
        <label>Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <label>Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" required
               value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>">

        <label>DNI <span class="requerido">*</span></label>
        <input type="text" name="dni" required
               value="<?= htmlspecialchars($_POST['dni'] ?? '') ?>">

        <label>Tipo de persona <span class="requerido">*</span></label>
        <select name="tipo_persona" required>
            <option value="">-- Seleccione --</option>
            <option value="docente" <?= ($_POST['tipo_persona'] ?? '') === 'docente' ? 'selected' : '' ?>>Docente</option>
            <option value="estudiante" <?= ($_POST['tipo_persona'] ?? '') === 'estudiante' ? 'selected' : '' ?>>Estudiante</option>
            <option value="personal_administrativo" <?= ($_POST['tipo_persona'] ?? '') === 'personal_administrativo' ? 'selected' : '' ?>>Personal administrativo</option>
        </select>

        <label>Teléfono</label>
        <input type="text" name="telefono"
               value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">

        <label>Email</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <button type="submit">Registrar</button>
    </form>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Préstamos de Herramientas</p>
</footer>

</body>
</html>