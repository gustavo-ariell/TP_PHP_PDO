<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_especialidad"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM especialidad WHERE id_especialidad = :id_especialidad";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_especialidad' => $id]);

        $mensaje = "Especialidad eliminada correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar la especialidad. Puede tener médicos asociados.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre FROM especialidad WHERE id_especialidad = :id_especialidad";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_especialidad' => $id]);
$especialidad = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar especialidad</title>
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

    <h2>Eliminar especialidad</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($especialidad && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar la especialidad
           <strong><?= htmlspecialchars($especialidad['nombre']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_especialidad" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de especialidades</a></p>

    <?php } ?>

</main>

</body>
</html>