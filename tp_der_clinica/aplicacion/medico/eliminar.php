<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_medico"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM medico WHERE id_medico = :id_medico";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_medico' => $id]);

        $mensaje = "Médico eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el médico. Puede tener turnos asociados.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre, apellido, matricula FROM medico WHERE id_medico = :id_medico";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_medico' => $id]);
$medico = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar médico</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TURNOS CLÍNICA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Médicos ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar médico</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($medico && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar al médico
           <strong><?= htmlspecialchars($medico['nombre'] . " " . $medico['apellido']) ?></strong>
           (Matrícula: <?= htmlspecialchars($medico['matricula']) ?>)?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_medico" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de médicos</a></p>

    <?php } ?>

</main>

</body>
</html>