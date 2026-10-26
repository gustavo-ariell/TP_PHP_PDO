<?php
session_start();
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

// Mostrar mensaje desde sesión (después del redirect)
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    $tipo_mensaje = $_SESSION['tipo_mensaje'];
    unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_turno = (int)($_POST["id_turno"] ?? 0);
    $id_paciente = $_POST["id_paciente"] ?? "";
    $id_medico = $_POST["id_medico"] ?? "";
    $id_consultorio = $_POST["id_consultorio"] ?? "";
    $fecha = $_POST["fecha"] ?? "";
    $hora = $_POST["hora"] ?? "";
    $estado = $_POST["estado"] ?? "";

    if ($id_paciente === "" || $id_medico === "" || $id_consultorio === "" ||
        $fecha === "" || $hora === "") {

        $mensaje = "Debe completar todos los campos obligatorios.";
        $tipo_mensaje = "error";

    } elseif (!in_array($estado, ["reservado", "atendido", "cancelado", "ausente"])) {

        $mensaje = "El estado debe ser reservado, atendido, cancelado o ausente.";
        $tipo_mensaje = "error";

    } else {

        $sql = "UPDATE turno SET
                    id_paciente = :id_paciente,
                    id_medico = :id_medico,
                    id_consultorio = :id_consultorio,
                    fecha = :fecha,
                    hora = :hora,
                    estado = :estado
                WHERE id_turno = :id_turno";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_paciente'     => (int)$id_paciente,
                ':id_medico'       => (int)$id_medico,
                ':id_consultorio'  => (int)$id_consultorio,
                ':fecha'           => $fecha,
                ':hora'            => $hora,
                ':estado'          => $estado,
                ':id_turno'        => $id_turno
            ]);

            $_SESSION['mensaje'] = "Turno modificado correctamente.";
            $_SESSION['tipo_mensaje'] = "exito";

            header("Location: editar.php?id_turno=" . $id_turno);
            exit;

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el turno.";
            $tipo_mensaje = "error";
        }
    }
}

// Recibir el id desde POST (tras validación) o desde GET (carga inicial)
$id = (int)($_POST["id_turno"] ?? $_GET["id_turno"] ?? $_GET["id"] ?? 0);

if ($id <= 0) {
    die("No se especificó un turno válido. <a href='listar.php'>Volver al listado</a>");
}

$sql = "SELECT id_turno, id_paciente, id_medico, id_consultorio, fecha, hora, estado
        FROM turno WHERE id_turno = :id_turno";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_turno' => $id]);
$turno = $stmt->fetch();

if (!$turno) {
    die("El turno solicitado no existe. <a href='listar.php'>Volver al listado</a>");
}

$pacientes = $pdo->query("SELECT id_paciente, nombre, apellido, dni FROM paciente ORDER BY apellido")->fetchAll();
$medicos = $pdo->query("SELECT id_medico, nombre, apellido, matricula FROM medico ORDER BY apellido")->fetchAll();
$consultorios = $pdo->query("SELECT id_consultorio, numero, piso FROM consultorio ORDER BY numero")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar turno</title>
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

    <h2>Modificar estado de turno</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_turno" value="<?= $turno['id_turno'] ?>">

        <label for="id_paciente">Paciente <span class="requerido">*</span></label>
        <select name="id_paciente" id="id_paciente" required>
            <?php foreach ($pacientes as $paciente) { ?>
                <option value="<?= $paciente['id_paciente'] ?>"
                    <?= $paciente['id_paciente'] == $turno['id_paciente'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($paciente['apellido'] . ", " . $paciente['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_medico">Médico <span class="requerido">*</span></label>
        <select name="id_medico" id="id_medico" required>
            <?php foreach ($medicos as $medico) { ?>
                <option value="<?= $medico['id_medico'] ?>"
                    <?= $medico['id_medico'] == $turno['id_medico'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($medico['apellido'] . ", " . $medico['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_consultorio">Consultorio <span class="requerido">*</span></label>
        <select name="id_consultorio" id="id_consultorio" required>
            <?php foreach ($consultorios as $consultorio) { ?>
                <option value="<?= $consultorio['id_consultorio'] ?>"
                    <?= $consultorio['id_consultorio'] == $turno['id_consultorio'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($consultorio['numero']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha">Fecha <span class="requerido">*</span></label>
        <input type="date" name="fecha" id="fecha" required
               value="<?= htmlspecialchars($turno['fecha']) ?>">

        <label for="hora">Hora <span class="requerido">*</span></label>
        <input type="time" name="hora" id="hora" required
               value="<?= htmlspecialchars($turno['hora']) ?>">

        <label for="estado">Estado <span class="requerido">*</span></label>
        <select name="estado" id="estado" required>
            <option value="reservado" <?= $turno['estado'] === 'reservado' ? "selected" : "" ?>>Reservado</option>
            <option value="atendido" <?= $turno['estado'] === 'atendido' ? "selected" : "" ?>>Atendido</option>
            <option value="cancelado" <?= $turno['estado'] === 'cancelado' ? "selected" : "" ?>>Cancelado</option>
            <option value="ausente" <?= $turno['estado'] === 'ausente' ? "selected" : "" ?>>Ausente</option>
        </select>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>
