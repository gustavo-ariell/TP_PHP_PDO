<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni = trim($_POST["dni"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if ($nombre === "" || $apellido === "" || $dni === "") {
        $mensaje = "Debe ingresar un nombre, un apellido y un DNI.";
        $tipo_mensaje = "error";
    } elseif ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Debe ingresar un correo electrónico válido.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO huesped (nombre, apellido, dni, telefono, email)
                VALUES (:nombre, :apellido, :dni, :telefono, :email)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'   => $nombre,
                ':apellido' => $apellido,
                ':dni'      => $dni,
                ':telefono' => $telefono,
                ':email'    => $email
            ]);

            $mensaje = "Huésped registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el huésped. El DNI ya existe.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar huésped</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Huéspedes ]</a>
        <a href="alta.php">[ Nuevo huésped ]</a>
        <a href="../habitacion/listar.php">[ Habitaciones ]</a>
        <a href="../reserva/listar.php">[ Reservas ]</a>
    </nav>
</header>

<main>

    <h2>Registrar huésped</h2>

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

        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <button type="submit">Registrar huésped</button>

    </form>

    <p><a href="listar.php">Volver al listado de huéspedes</a></p>

</main>

</body>
</html>