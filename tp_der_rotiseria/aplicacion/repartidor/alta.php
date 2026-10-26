<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");

    if ($nombre === "" || $apellido === "") {
        $mensaje = "Debe ingresar un nombre y un apellido.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO repartidor (nombre, apellido, telefono)
                VALUES (:nombre, :apellido, :telefono)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'    => $nombre,
                ':apellido'  => $apellido,
                ':telefono'  => $telefono
            ]);

            $mensaje = "Repartidor registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el repartidor.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar repartidor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PEDIDOS — ROTISERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Repartidores ]</a>
        <a href="alta.php">[ Nuevo repartidor ]</a>
        <a href="../pedido/listar.php">[ Pedidos ]</a>
        <a href="../cliente/listar.php">[ Clientes ]</a>
    </nav>
</header>

<main>

    <h2>Registrar repartidor</h2>

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

        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono"
               value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">

        <button type="submit">Registrar repartidor</button>

    </form>

    <p><a href="listar.php">Volver al listado de repartidores</a></p>

</main>

</body>
</html>