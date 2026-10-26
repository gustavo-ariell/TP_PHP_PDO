<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_paciente = (int)($_POST["id_paciente"] ?? 0);
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

        $sql = "UPDATE paciente SET
                    nombre = :nombre,
                    apellido = :apellido,
                    dni = :dni,
                    fecha_nacimiento = :fecha_nacimiento,
                    telefono = :telefono,
                    obra_social = :obra_social
                WHERE id_paciente = :id_paciente";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'            => $nombre,
                ':apellido'          => $apellido,
                ':dni'               => $dni,
                ':fecha_nacimiento'  => ($fecha_nacimiento === "" ? null : $fecha_nacimiento),
                ':telefono'          => $telefono,
                ':obra_social'       => $obra_social,
                ':id_paciente'       => $id_paciente
            ]);

            $mensaje = "Paciente modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el paciente. El DNI ya existe.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_paciente"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_paciente, nombre, apellido, dni, fecha_nacimiento, telefono, obra_social
        FROM paciente WHERE id_paciente = :id_paciente";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_paciente' => $id]);
$paciente = $stmt->fetch();

if (!$paciente) {
    die("El paciente solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar paciente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TURNOS CLÍNICA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Pacientes ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del paciente</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_paciente" value="<?= $paciente['id_paciente'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($paciente['nombre']) ?>">

        <label for="apellido">Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" id="apellido" required
               value="<?= htmlspecialchars($paciente['apellido']) ?>">

        <label for="dni">DNI <span class="requerido">*</span></label>
        <input type="text" name="dni" id="dni" required
               value="<?= htmlspecialchars($paciente['dni']) ?>">

        <label for="fecha_nacimiento">Fecha de nacimiento</label>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
               value="<?= htmlspecialchars((string)$paciente['fecha_nacimiento']) ?>">

        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono"
               value="<?= htmlspecialchars((string)$paciente['telefono']) ?>">

        <label for="obra_social">Obra social</label>
        <input type="text" name="obra_social" id="obra_social"
               value="<?= htmlspecialchars((string)$paciente['obra_social']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>