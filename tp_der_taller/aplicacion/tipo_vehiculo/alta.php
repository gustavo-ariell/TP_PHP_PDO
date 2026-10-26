<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");

    if ($nombre === "") {
        $mensaje = "Debe ingresar el nombre del tipo de vehículo.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO tipo_vehiculo (nombre) VALUES (:nombre)";

        try {

            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nombre' => $nombre]);

            $mensaje = "Tipo de vehículo registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el tipo de vehículo.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar tipo de vehículo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Tipos de vehículo ]</a>
        <a href="alta.php">[ Nuevo tipo ]</a>
        <a href="../vehiculo/listar.php">[ Vehículos ]</a>
    </nav>
</header>

<main>

    <h2>Registrar tipo de vehículo</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <button type="submit">Registrar tipo</button>

    </form>

    <p><a href="listar.php">Volver al listado de tipos</a></p>

</main>

</body>
</html>