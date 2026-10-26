<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $precio = trim($_POST["precio"] ?? "");

    if ($nombre === "") {
        $mensaje = "Debe ingresar el nombre del servicio.";
        $tipo_mensaje = "error";
    } elseif ($precio !== "" && (!is_numeric($precio) || (float)$precio < 0)) {
        $mensaje = "El precio debe ser un número mayor o igual a 0.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO servicio (nombre, descripcion, precio)
                VALUES (:nombre, :descripcion, :precio)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'      => $nombre,
                ':descripcion' => $descripcion,
                ':precio'      => ($precio === "" ? null : (float)$precio)
            ]);

            $mensaje = "Servicio registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el servicio.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar servicio</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Servicios ]</a>
        <a href="alta.php">[ Nuevo servicio ]</a>
        <a href="../reparacion/listar.php">[ Reparaciones ]</a>
    </nav>
</header>

<main>

    <h2>Registrar servicio</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>

        <label for="precio">Precio</label>
        <input type="number" name="precio" id="precio" step="0.01" min="0"
               value="<?= htmlspecialchars($_POST['precio'] ?? '') ?>">

        <button type="submit">Registrar servicio</button>

    </form>

    <p><a href="listar.php">Volver al listado de servicios</a></p>

</main>

</body>
</html>