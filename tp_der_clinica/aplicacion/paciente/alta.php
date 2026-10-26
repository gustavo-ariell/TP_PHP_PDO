<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni = trim($_POST["dni"] ?? "");
    $fecha_nacimiento = $_POST["fecha_nacimiento"] ?? "";
    $telefono = trim($_POST["telefono"] ?? "");
    $obra_social = trim($_POST["obra_social"] ?? "");

    if ($nombre === "" || $apellido === "" || $dni === "") {
        $mensaje = "Debe ingresar un nombre, un apellido y un DNI.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO paciente
                    (nombre, apellido, dni, fecha_nacimiento, telefono, obra_social)
                VALUES
                    (:nombre, :apellido, :dni, :fecha_nacimiento, :telefono, :obra_social)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'            => $nombre,
                ':apellido'          => $apellido,
                ':dni'               => $dni,
                ':fecha_nacimiento'  => ($fecha_nacimiento === "" ? null : $fecha_nacimiento),
                ':telefono'          => $telefono,
                ':obra_social'       => $obra_social
            ]);

            $mensaje = "Paciente registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el paciente. El DNI ya existe.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar paciente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TURNOS CLÍNICA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Pacientes ]</a>
        <a href="alta.php">[ Nuevo paciente ]</a>
        <a href="../medico/listar.php">[ Médicos ]</a>
        <a href="../turno/listar.php">[ Turnos ]</a>
    </nav>
</header>

<main>

    <h2>Registrar paciente</h2>

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

        <label for="fecha_nacimiento">Fecha de nacimiento</label>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
               value="<?= htmlspecialchars($_POST['fecha_nacimiento'] ?? '') ?>">

        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono"
               value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">

        <label for="obra_social">Obra social</label>
        <input type="text" name="obra_social" id="obra_social"
               value="<?= htmlspecialchars($_POST['obra_social'] ?? '') ?>">

        <button type="submit">Registrar paciente</button>

    </form>

    <p><a href="listar.php">Volver al listado de pacientes</a></p>

</main>

</body>
</html>