<?php
session_start();
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_turno"] ?? 0);

// Mostrar mensaje desde sesión (después del redirect)
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    $tipo_mensaje = $_SESSION['tipo_mensaje'];
    unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM turno WHERE id_turno = :id_turno";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_turno' => $id]);

        $_SESSION['mensaje'] = "Turno eliminado correctamente.";
        $_SESSION['tipo_mensaje'] = "exito";

        header("Location: listar.php");
        exit;

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el turno.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT
            t.fecha,
            t.hora,
            t.estado,
            p.nombre AS nombre_paciente,
            p.apellido AS apellido_paciente,
            m.nombre AS nombre_medico,
            m.apellido AS apellido_medico
        FROM turno t
        INNER JOIN paciente p ON t.id_paciente = p.id_paciente
        INNER JOIN medico m ON t.id_medico = m.id_medico
        WHERE t.id_turno = :id_turno";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_turno' => $id]);
$turno = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar turno</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TURNOS CLÍNICA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Turnos ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar turno</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($turno && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar el turno de
           <strong><?= htmlspecialchars($turno['nombre_paciente'] . " " . $turno['apellido_paciente']) ?></strong>
           con el Dr./Dra.
           <strong><?= htmlspecialchars($turno['nombre_medico'] . " " . $turno['apellido_medico']) ?></strong>
           el día <strong><?= htmlspecialchars($turno['fecha']) ?></strong>
           a las <strong><?= htmlspecialchars($turno['hora']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_turno" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de turnos</a></p>

    <?php } ?>

</main>

</body>
</html>
