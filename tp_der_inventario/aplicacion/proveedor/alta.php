<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $contacto = trim($_POST["contacto"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $direccion = trim($_POST["direccion"] ?? "");

    if ($nombre === "") {
        $mensaje = "Debe ingresar el nombre del proveedor.";
        $tipo_mensaje = "error";
    } elseif ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Debe ingresar un correo electrónico válido.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO proveedor (nombre, contacto, telefono, email, direccion)
                VALUES (:nombre, :contacto, :telefono, :email, :direccion)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'    => $nombre,
                ':contacto'  => $contacto,
                ':telefono'  => $telefono,
                ':email'     => $email,
                ':direccion' => $direccion
            ]);

            $mensaje = "Proveedor registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el proveedor.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar proveedor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE INVENTARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Proveedores ]</a>
        <a href="alta.php">[ Nuevo proveedor ]</a>
        <a href="../producto/listar.php">[ Productos ]</a>
        <a href="../categoria/listar.php">[ Categorías ]</a>
    </nav>
</header>

<main>

    <h2>Registrar proveedor</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <label for="contacto">Persona de contacto</label>
        <input type="text" name="contacto" id="contacto"
               value="<?= htmlspecialchars($_POST['contacto'] ?? '') ?>">

        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono"
               value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">

        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <label for="direccion">Dirección</label>
        <input type="text" name="direccion" id="direccion"
               value="<?= htmlspecialchars($_POST['direccion'] ?? '') ?>">

        <button type="submit">Registrar proveedor</button>

    </form>

    <p><a href="listar.php">Volver al listado de proveedores</a></p>

</main>

</body>
</html>