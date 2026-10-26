<?php
require_once "../conexion.php";

$especialidades = $pdo->query("SELECT id_especialidad, nombre FROM especialidad ORDER BY nombre")->fetchAll();

$id_especialidad = $_POST["id_especialidad"] ?? "";
$turnos = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_especialidad !== "") {

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
            WHERE e.id_especialidad = :id_especialidad
            ORDER BY t.fecha, t.hora";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_especialidad' => (int)$id_especialidad]);
    $turnos = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Turnos por especialidad</title>
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

    <h2>Turnos por especialidad</h2>

    <form action="turnos_por_especialidad.php" method="post">

        <label for="id_especialidad">Especialidad <span class="requerido">*</span></label>
        <select name="id_especialidad" id="id_especialidad" required>
            <option value="">Seleccione una especialidad</option>
            <?php foreach ($especialidades as $especialidad) { ?>
                <option value="<?= $especialidad['id_especialidad'] ?>"
                    <?= $especialidad['id_especialidad'] == $id_especialidad ? "selected" : "" ?>>
                    <?= htmlspecialchars($especialidad['nombre']) ?>
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
                <th>Paciente</th>
                <th>Médico</th>
                <th>Especialidad</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($turnos as $turno) { ?>
            <tr>
                <td><?= htmlspecialchars($turno['fecha']) ?></td>
                <td><?= htmlspecialchars($turno['hora']) ?></td>
                <td><?= htmlspecialchars($turno['apellido_paciente'] . ", " . $turno['nombre_paciente']) ?></td>
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