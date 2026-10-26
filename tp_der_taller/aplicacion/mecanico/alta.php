<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni = trim($_POST["dni"] ?? "");
    $especialidad = trim($_POST["especialidad"] ?? "");

    if ($nombre === "" || $apellido === "" || $dni === "") {
        $mensaje = "Debe ingresar un nombre, un apellido y un DNI.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO mecanico (nombre, apellido, dni, especialidad)
                VALUES (:nombre, :apellido, :dni, :especialidad)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'       => $nombre,
                ':apellido'     => $apellido,
                ':dni'          => $dni,
                ':especialidad' => $especialidad
            ]);

            $mensaje = "Mecánico registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el mecánico. El DNI ya existe.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar mecánico</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Mecánicos ]</a>
        <a href="alta.php">[ Nuevo mecánico ]</a>
        <a href="../reparacion/listar.php">[ Reparaciones ]</a>
        <a href="../vehiculo/listar.php">[ Vehículos ]</a>
    </nav>
</header>

<main>

    <h2>Registrar mecánico</h2>

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

        <label for="especialidad">Especialidad</label>
        <input type="text" name="especialidad" id="especialidad"
               value="<?= htmlspecialchars($_POST['especialidad'] ?? '') ?>">

        <button type="submit">Registrar mecánico</button>

    </form>

    <p><a href="listar.php">Volver al listado de mecánicos</a></p>

</main>

</body>
</html>