<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_asistente = (int)($_POST["id_asistente"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni = trim($_POST["dni"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $institucion = trim($_POST["institucion"] ?? "");

    if ($nombre === "" || $apellido === "" || $dni === "") {
        $mensaje = "Debe ingresar un nombre, un apellido y un DNI.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE asistente SET
                    nombre = :nombre,
                    apellido = :apellido,
                    dni = :dni,
                    email = :email,
                    institucion = :institucion
                WHERE id_asistente = :id_asistente";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'      => $nombre,
                ':apellido'    => $apellido,
                ':dni'         => $dni,
                ':email'       => $email,
                ':institucion' => $institucion,
                ':id_asistente' => $id_asistente
            ]);

            $mensaje = "Asistente modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el asistente. El DNI ya existe.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_asistente"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_asistente, nombre, apellido, dni, email, institucion
        FROM asistente WHERE id_asistente = :id_asistente";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_asistente' => $id]);
$asistente = $stmt->fetch();

if (!$asistente) {
    die("El asistente solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar asistente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Asistentes ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del asistente</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_asistente" value="<?= $asistente['id_asistente'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($asistente['nombre']) ?>">

        <label for="apellido">Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" id="apellido" required
               value="<?= htmlspecialchars($asistente['apellido']) ?>">

        <label for="dni">DNI <span class="requerido">*</span></label>
        <input type="text" name="dni" id="dni" required
               value="<?= htmlspecialchars($asistente['dni']) ?>">

        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars((string)$asistente['email']) ?>">

        <label for="institucion">Institución</label>
        <input type="text" name="institucion" id="institucion"
               value="<?= htmlspecialchars((string)$asistente['institucion']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>