<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $direccion = trim($_POST["direccion"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");

    if ($nombre === "") {

        $mensaje = "Debe ingresar el nombre de la editorial.";
        $tipo_mensaje = "error";

    } else {

        $sql = "INSERT INTO editorial (nombre, direccion, telefono)
                VALUES (:nombre, :direccion, :telefono)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'    => $nombre,
                ':direccion' => $direccion,
                ':telefono'  => $telefono
            ]);

            $mensaje = "Editorial registrada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar la editorial.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar editorial</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Editoriales ]</a>
        <a href="alta.php">[ Nueva editorial ]</a>
        <a href="../libro/listar.php">[ Libros ]</a>
        <a href="../autor/listar.php">[ Autores ]</a>
        <a href="../prestamo/listar.php">[ Préstamos ]</a>
    </nav>
</header>

<main>

    <h2>Registrar editorial</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <label for="direccion">Dirección</label>
        <input type="text" name="direccion" id="direccion"
               value="<?= htmlspecialchars($_POST['direccion'] ?? '') ?>">

        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono"
               value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">

        <button type="submit">Registrar editorial</button>

    </form>

    <p><a href="listar.php">Volver al listado de editoriales</a></p>

</main>

</body>
</html>