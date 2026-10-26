<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_repartidor = (int)($_POST["id_repartidor"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");

    if ($nombre === "" || $apellido === "") {
        $mensaje = "Debe ingresar un nombre y un apellido.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE repartidor SET
                    nombre = :nombre,
                    apellido = :apellido,
                    telefono = :telefono
                WHERE id_repartidor = :id_repartidor";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'       => $nombre,
                ':apellido'     => $apellido,
                ':telefono'     => $telefono,
                ':id_repartidor' => $id_repartidor
            ]);

            $mensaje = "Repartidor modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el repartidor.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_repartidor"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_repartidor, nombre, apellido, telefono
        FROM repartidor WHERE id_repartidor = :id_repartidor";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_repartidor' => $id]);
$repartidor = $stmt->fetch();

if (!$repartidor) {
    die("El repartidor solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar repartidor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PEDIDOS — ROTISERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Repartidores ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del repartidor</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_repartidor" value="<?= $repartidor['id_repartidor'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($repartidor['nombre']) ?>">

        <label for="apellido">Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" id="apellido" required
               value="<?= htmlspecialchars($repartidor['apellido']) ?>">

        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono"
               value="<?= htmlspecialchars((string)$repartidor['telefono']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>