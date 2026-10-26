<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_servicio = (int)($_POST["id_servicio"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $precio = trim($_POST["precio"] ?? "");

    if ($nombre === "") {
        $mensaje = "Debe ingresar el nombre del servicio.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE servicio SET
                    nombre = :nombre,
                    descripcion = :descripcion,
                    precio = :precio
                WHERE id_servicio = :id_servicio";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'      => $nombre,
                ':descripcion' => $descripcion,
                ':precio'      => ($precio === "" ? null : (float)$precio),
                ':id_servicio' => $id_servicio
            ]);

            $mensaje = "Servicio modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el servicio.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_servicio"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_servicio, nombre, descripcion, precio
        FROM servicio WHERE id_servicio = :id_servicio";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_servicio' => $id]);
$servicio = $stmt->fetch();

if (!$servicio) {
    die("El servicio solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar servicio</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Servicios ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del servicio</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_servicio" value="<?= $servicio['id_servicio'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($servicio['nombre']) ?>">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3"><?= htmlspecialchars((string)$servicio['descripcion']) ?></textarea>

        <label for="precio">Precio</label>
        <input type="number" name="precio" id="precio" step="0.01" min="0"
               value="<?= $servicio['precio'] !== null ? $servicio['precio'] : '' ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>