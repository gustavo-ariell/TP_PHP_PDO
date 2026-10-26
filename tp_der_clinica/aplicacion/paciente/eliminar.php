<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_paciente"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM paciente WHERE id_paciente = :id_paciente";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_paciente' => $id]);

        $mensaje = "Paciente eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el paciente. Puede tener turnos asociados.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre, apellido FROM paciente WHERE id_paciente = :id_paciente";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_paciente' => $id]);
$paciente = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar paciente</title>
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

    <h2>Eliminar paciente</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($paciente && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar al paciente
           <strong><?= htmlspecialchars($paciente['nombre'] . " " . $paciente['apellido']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_paciente" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de pacientes</a></p>

    <?php } ?>

</main>

</body>
</html>