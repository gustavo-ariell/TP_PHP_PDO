<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_tipo = (int)($_POST["id_tipo"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");

    if ($nombre === "") {
        $mensaje = "Debe ingresar el nombre del tipo de vehículo.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE tipo_vehiculo SET nombre = :nombre WHERE id_tipo = :id_tipo";

        try {

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nombre'  => $nombre,
                ':id_tipo' => $id_tipo
            ]);

            $mensaje = "Tipo de vehículo modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el tipo de vehículo.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_tipo"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_tipo, nombre FROM tipo_vehiculo WHERE id_tipo = :id_tipo";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_tipo' => $id]);
$tipo = $stmt->fetch();

if (!$tipo) {
    die("El tipo de vehículo solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar tipo de vehículo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Tipos de vehículo ]</a>
    </nav>
</header>

<main>

    <h2>Modificar tipo de vehículo</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_tipo" value="<?= $tipo['id_tipo'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($tipo['nombre']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>