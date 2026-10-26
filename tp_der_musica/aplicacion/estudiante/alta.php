<?php
require_once "../conexion.php";

$mensaje = "";
$error   = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre   = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni      = trim($_POST["dni"] ?? "");
    $edad     = trim($_POST["edad"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");

    if ($nombre === "" || $apellido === "" || $dni === "") {
        $error = "Debe ingresar nombre, apellido y DNI.";
    } elseif (!ctype_digit($dni)) {
        $error = "El DNI debe contener solo números.";
    } elseif ($edad !== "" && (!ctype_digit($edad) || (int)$edad < 1)) {
        $error = "La edad debe ser un número entero mayor que cero.";
    } else {

        $edad = ($edad === "") ? null : (int)$edad;

        try {

            $sql = "INSERT INTO estudiante (nombre, apellido, dni, edad, telefono)
                    VALUES (:nombre, :apellido, :dni, :edad, :telefono)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":nombre"   => $nombre,
                ":apellido" => $apellido,
                ":dni"      => $dni,
                ":edad"     => $edad,
                ":telefono" => $telefono
            ]);

            $mensaje = "Estudiante registrado correctamente.";

        } catch (PDOException $e) {
            $error = "No se pudo registrar el estudiante. Verifique que el DNI no esté repetido.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar estudiante</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>REGISTRAR ESTUDIANTE</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar estudiantes ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje exito"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <?php if ($error !== ""): ?>
        <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <h2>Nuevo estudiante</h2>

    <form action="alta.php" method="POST">
        <label>Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" required>

        <label>Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" required>

        <label>DNI <span class="requerido">*</span></label>
        <input type="text" name="dni" required>

        <label>Edad</label>
        <input type="number" name="edad" min="1">

        <label>Teléfono</label>
        <input type="text" name="telefono">

        <button type="submit">Registrar</button>
    </form>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>