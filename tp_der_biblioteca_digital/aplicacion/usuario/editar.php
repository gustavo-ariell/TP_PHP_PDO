<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_usuario = (int)($_POST["id_usuario"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $fecha_registro = $_POST["fecha_registro"] ?? "";

    if ($nombre === "" || $apellido === "" || $email === "" || $fecha_registro === "") {
        $mensaje = "Debe completar todos los campos obligatorios.";
        $tipo_mensaje = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Debe ingresar un correo electrónico válido.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE usuario SET
                    nombre = :nombre,
                    apellido = :apellido,
                    email = :email,
                    fecha_registro = :fecha_registro
                WHERE id_usuario = :id_usuario";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'         => $nombre,
                ':apellido'       => $apellido,
                ':email'          => $email,
                ':fecha_registro' => $fecha_registro,
                ':id_usuario'     => $id_usuario
            ]);

            $mensaje = "Usuario modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el usuario. El correo ya existe.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_usuario"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_usuario, nombre, apellido, email, fecha_registro
        FROM usuario WHERE id_usuario = :id_usuario";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_usuario' => $id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    die("El usuario solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar usuario</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Usuarios ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del usuario</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($usuario['nombre']) ?>">

        <label for="apellido">Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" id="apellido" required
               value="<?= htmlspecialchars($usuario['apellido']) ?>">

        <label for="email">Correo electrónico <span class="requerido">*</span></label>
        <input type="email" name="email" id="email" required
               value="<?= htmlspecialchars($usuario['email']) ?>">

        <label for="fecha_registro">Fecha de registro <span class="requerido">*</span></label>
        <input type="date" name="fecha_registro" id="fecha_registro" required
               value="<?= htmlspecialchars($usuario['fecha_registro']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>