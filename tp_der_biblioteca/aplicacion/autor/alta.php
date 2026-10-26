<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $nacionalidad = trim($_POST["nacionalidad"] ?? "");

    if ($nombre === "" || $apellido === "") {

        $mensaje = "Debe ingresar un nombre y un apellido.";
        $tipo_mensaje = "error";

    } else {

        $sql = "INSERT INTO autor (nombre, apellido, nacionalidad)
                VALUES (:nombre, :apellido, :nacionalidad)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'       => $nombre,
                ':apellido'     => $apellido,
                ':nacionalidad' => $nacionalidad
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
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Autores ]</a>
        <a href="alta.php">[ Nuevo autor ]</a>
        <a href="../libro/listar.php">[ Libros ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
        <a href="../prestamo/listar.php">[ Préstamos ]</a>
    </nav>
</header>

<main>

    <h2>Registrar autor</h2>

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

        <label for="nacionalidad">Nacionalidad</label>
        <input type="text" name="nacionalidad" id="nacionalidad"
               value="<?= htmlspecialchars($_POST['nacionalidad'] ?? '') ?>">

        <button type="submit">Registrar autor</button>

    </form>

    <p><a href="listar.php">Volver al listado de autores</a></p>

</main>

</body>
</html>