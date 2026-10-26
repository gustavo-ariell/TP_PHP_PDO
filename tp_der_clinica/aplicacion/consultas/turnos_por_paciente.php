<?php
require_once "../conexion.php";

$pacientes = $pdo->query("SELECT id_paciente, nombre, apellido, dni FROM paciente ORDER BY apellido")->fetchAll();

$id_paciente = $_POST["id_paciente"] ?? "";
$turnos = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_paciente !== "") {

    $sql = "SELECT
                t.fecha,
                t.hora,
                t.estado,
                p.nombre AS nombre_paciente,
                p.apellido AS apellido_paciente,
                m.nombre AS nombre_medico,
                m.apellido AS apellido_medico,
                e.nombre AS especialidad
            FROM turno t
            INNER JOIN paciente p ON t.id_paciente = p.id_paciente
            INNER JOIN medico m ON t.id_medico = m.id_medico
            INNER JOIN especialidad e ON m.id_especialidad = e.id_especialidad
            WHERE p.id_paciente = :id_paciente
            ORDER BY t.fecha, t.hora";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_paciente' => (int)$id_paciente]);
    $turnos = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Turnos por paciente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TURNOS CLÍNICA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="turnos_por_medico.php">[ Por médico ]</a>
        <a href="turnos_por_paciente.php">[ Por paciente ]</a>
        <a href="turnos_por_fecha.php">[ Por fecha ]</a>
        <a href="turnos_por_especialidad.php">[ Por especialidad ]</a>
        <a href="../turno/listar.php">[ Turnos ]</a>
    </nav>
</header>

<main>

    <h2>Turnos por paciente</h2>

    <form action="turnos_por_paciente.php" method="post">

        <label for="id_paciente">Paciente <span class="requerido">*</span></label>
        <select name="id_paciente" id="id_paciente" required>
            <option value="">Seleccione un paciente</option>
            <?php foreach ($pacientes as $paciente) { ?>
                <option value="<?= $paciente['id_paciente'] ?>"
                    <?= $paciente['id_paciente'] == $id_paciente ? "selected" : "" ?>>
                    <?= htmlspecialchars($paciente['apellido'] . ", " . $paciente['nombre'] . " (DNI: " . $paciente['dni'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>

        <table>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Médico</th>
                <th>Especialidad</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($turnos as $turno) { ?>
            <tr>
                <td><?= htmlspecialchars($turno['fecha']) ?></td>
                <td><?= htmlspecialchars($turno['hora']) ?></td>
                <td><?= htmlspecialchars($turno['apellido_medico'] . ", " . $turno['nombre_medico']) ?></td>
                <td><?= htmlspecialchars($turno['especialidad']) ?></td>
                <td><?= htmlspecialchars($turno['estado']) ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>