<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni = trim($_POST["dni"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $direccion = trim($_POST["direccion"] ?? "");

    if ($nombre === "" || $apellido === "" || $dni === "") {
        $mensaje = "Debe ingresar un nombre, un apellido y un DNI.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO cliente (nombre, apellido, dni, telefono, direccion)
                VALUES (:nombre, :apellido, :dni, :telefono, :direccion)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'    => $nombre,
                ':apellido'  => $apellido,
                ':dni'       => $dni,
                ':telefono'  => $telefono,
                ':direccion' => $direccion
            ]);

            $mensaje = "Cliente registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el cliente. El DNI ya existe.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar cliente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PEDIDOS — ROTISERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Clientes ]</a>
        <a href="alta.php">[ Nuevo cliente ]</a>
        <a href="../pedido/listar.php">[ Pedidos ]</a>
        <a href="../producto/listar.php">[ Productos ]</a>
    </nav>
</header>

<main>

    <h2>Registrar cliente</h2>

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

        <label for="dni">DNI <span class="requerido">*</span></label>
        <input type="text" name="dni" id="dni" required
               value="<?= htmlspecialchars($_POST['dni'] ?? '') ?>">

        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono"
               value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">

        <label for="direccion">Dirección</label>
        <input type="text" name="direccion" id="direccion"
               value="<?= htmlspecialchars($_POST['direccion'] ?? '') ?>">

        <button type="submit">Registrar cliente</button>

    </form>

    <p><a href="listar.php">Volver al listado de clientes</a></p>

</main>

</body>
</html>