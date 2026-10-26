<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_paciente = $_POST["id_paciente"] ?? "";
    $id_medico = $_POST["id_medico"] ?? "";
    $id_consultorio = $_POST["id_consultorio"] ?? "";
    $fecha = $_POST["fecha"] ?? "";
    $hora = $_POST["hora"] ?? "";
    $estado = $_POST["estado"] ?? "";

    if ($id_paciente === "" || $id_medico === "" || $id_consultorio === "" ||
        $fecha === "" || $hora === "") {

        $mensaje = "Debe seleccionar un paciente, un médico, un consultorio, e ingresar fecha y hora.";
        $tipo_mensaje = "error";

    } elseif (!in_array($estado, ["reservado", "atendido", "cancelado", "ausente"])) {

        $mensaje = "El estado debe ser reservado, atendido, cancelado o ausente.";
        $tipo_mensaje = "error";

    } else {

        $sql = "INSERT INTO turno (id_paciente, id_medico, id_consultorio, fecha, hora, estado)
                VALUES (:id_paciente, :id_medico, :id_consultorio, :fecha, :hora, :estado)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_paciente'     => (int)$id_paciente,
                ':id_medico'       => (int)$id_medico,
                ':id_consultorio'  => (int)$id_consultorio,
                ':fecha'           => $fecha,
                ':hora'            => $hora,
                ':estado'          => $estado
            ]);

            $mensaje = "Turno solicitado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo solicitar el turno.";
            $tipo_mensaje = "error";
        }
    }
}

$pacientes = $pdo->query("SELECT id_paciente, nombre, apellido, dni FROM paciente ORDER BY apellido")->fetchAll();
$medicos = $pdo->query("SELECT id_medico, nombre, apellido, matricula FROM medico ORDER BY apellido")->fetchAll();
$consultorios = $pdo->query("SELECT id_consultorio, numero, piso FROM consultorio ORDER BY numero")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitar turno</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TURNOS CLÍNICA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Turnos ]</a>
        <a href="alta.php">[ Nuevo turno ]</a>
        <a href="../paciente/listar.php">[ Pacientes ]</a>
        <a href="../medico/listar.php">[ Médicos ]</a>
    </nav>
</header>

<main>

    <h2>Solicitar turno</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="id_paciente">Paciente <span class="requerido">*</span></label>
        <select name="id_paciente" id="id_paciente" required>
            <option value="">Seleccione un paciente</option>
            <?php foreach ($pacientes as $paciente) { ?>
                <option value="<?= $paciente['id_paciente'] ?>">
                    <?= htmlspecialchars($paciente['apellido'] . ", " . $paciente['nombre'] . " (DNI: " . $paciente['dni'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_medico">Médico <span class="requerido">*</span></label>
        <select name="id_medico" id="id_medico" required>
            <option value="">Seleccione un médico</option>
            <?php foreach ($medicos as $medico) { ?>
                <option value="<?= $medico['id_medico'] ?>">
                    <?= htmlspecialchars($medico['apellido'] . ", " . $medico['nombre'] . " (MP: " . $medico['matricula'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_consultorio">Consultorio <span class="requerido">*</span></label>
        <select name="id_consultorio" id="id_consultorio" required>
            <option value="">Seleccione un consultorio</option>
            <?php foreach ($consultorios as $consultorio) { ?>
                <option value="<?= $consultorio['id_consultorio'] ?>">
                    <?= htmlspecialchars($consultorio['numero'] . " — Piso " . (string)$consultorio['piso']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha">Fecha <span class="requerido">*</span></label>
        <input type="date" name="fecha" id="fecha" required
               value="<?= date('Y-m-d') ?>">

        <label for="hora">Hora <span class="requerido">*</span></label>
        <input type="time" name="hora" id="hora" required
               value="<?= htmlspecialchars($_POST['hora'] ?? '08:00') ?>">

        <label for="estado">Estado <span class="requerido">*</span></label>
        <select name="estado" id="estado" required>
            <option value="reservado">Reservado</option>
            <option value="atendido">Atendido</option>
            <option value="cancelado">Cancelado</option>
            <option value="ausente">Ausente</option>
        </select>

        <button type="submit">Solicitar turno</button>

    </form>

    <p><a href="listar.php">Volver al listado de turnos</a></p>

</main>

</body>
</html>