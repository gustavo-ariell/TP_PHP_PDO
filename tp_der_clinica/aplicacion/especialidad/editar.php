<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_especialidad = (int)($_POST["id_especialidad"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");

    if ($nombre === "") {
        $mensaje = "Debe ingresar el nombre de la especialidad.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE especialidad SET nombre = :nombre
                WHERE id_especialidad = :id_especialidad";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'          => $nombre,
                ':id_especialidad' => $id_especialidad
            ]);

            $mensaje = "Especialidad modificada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar la especialidad.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_especialidad"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_especialidad, nombre FROM especialidad WHERE id_especialidad = :id_especialidad";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_especialidad' => $id]);
$especialidad = $stmt->fetch();

if (!$especialidad) {
    die("La especialidad solicitada no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar especialidad</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TURNOS CLÍNICA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Especialidades ]</a>
    </nav>
</header>

<main>

    <h2>Modificar especialidad</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_especialidad" value="<?= $especialidad['id_especialidad'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($especialidad['nombre']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>