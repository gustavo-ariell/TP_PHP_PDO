<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_mecanico = (int)($_POST["id_mecanico"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni = trim($_POST["dni"] ?? "");
    $especialidad = trim($_POST["especialidad"] ?? "");

    if ($nombre === "" || $apellido === "" || $dni === "") {
        $mensaje = "Debe ingresar un nombre, un apellido y un DNI.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE mecanico SET
                    nombre = :nombre,
                    apellido = :apellido,
                    dni = :dni,
                    especialidad = :especialidad
                WHERE id_mecanico = :id_mecanico";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'       => $nombre,
                ':apellido'     => $apellido,
                ':dni'          => $dni,
                ':especialidad' => $especialidad,
                ':id_mecanico'  => $id_mecanico
            ]);

            $mensaje = "Mecánico modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el mecánico. El DNI ya existe.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_mecanico"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_mecanico, nombre, apellido, dni, especialidad
        FROM mecanico WHERE id_mecanico = :id_mecanico";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_mecanico' => $id]);
$mecanico = $stmt->fetch();

if (!$mecanico) {
    die("El mecánico solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar mecánico</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Mecánicos ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del mecánico</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_mecanico" value="<?= $mecanico['id_mecanico'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($mecanico['nombre']) ?>">

        <label for="apellido">Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" id="apellido" required
               value="<?= htmlspecialchars($mecanico['apellido']) ?>">

        <label for="dni">DNI <span class="requerido">*</span></label>
        <input type="text" name="dni" id="dni" required
               value="<?= htmlspecialchars($mecanico['dni']) ?>">

        <label for="especialidad">Especialidad</label>
        <input type="text" name="especialidad" id="especialidad"
               value="<?= htmlspecialchars((string)$mecanico['especialidad']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>