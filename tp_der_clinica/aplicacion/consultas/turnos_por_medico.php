<?php
require_once "../conexion.php";

$medicos = $pdo->query("SELECT id_medico, nombre, apellido, matricula FROM medico ORDER BY apellido")->fetchAll();

$id_medico = $_POST["id_medico"] ?? "";
$turnos = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_medico !== "") {

    $sql = "SELECT
                t.fecha,
                t.hora,
                t.estado,
                p.nombre AS nombre_paciente,
                p.apellido AS apellido_paciente,
                m.nombre AS nombre_medico,
                m.apellido AS apellido_medico,
                c.numero AS consultorio
            FROM turno t
            INNER JOIN paciente p ON t.id_paciente = p.id_paciente
            INNER JOIN medico m ON t.id_medico = m.id_medico
            INNER JOIN consultorio c ON t.id_consultorio = c.id_consultorio
            WHERE m.id_medico = :id_medico
            ORDER BY t.fecha, t.hora";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_medico' => (int)$id_medico]);
    $turnos = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Turnos por médico</title>
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

    <h2>Turnos por médico</h2>

    <form action="turnos_por_medico.php" method="post">

        <label for="id_medico">Médico <span class="requerido">*</span></label>
        <select name="id_medico" id="id_medico" required>
            <option value="">Seleccione un médico</option>
            <?php foreach ($medicos as $medico) { ?>
                <option value="<?= $medico['id_medico'] ?>"
                    <?= $medico['id_medico'] == $id_medico ? "selected" : "" ?>>
                    <?= htmlspecialchars($medico['apellido'] . ", " . $medico['nombre'] . " (MP: " . $medico['matricula'] . ")") ?>
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
                <th>Consultorio</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($turnos as $turno) { ?>
            <tr>
                <td><?= htmlspecialchars($turno['fecha']) ?></td>
                <td><?= htmlspecialchars($turno['hora']) ?></td>
                <td><?= htmlspecialchars($turno['apellido_paciente'] . ", " . $turno['nombre_paciente']) ?></td>
                <td><?= htmlspecialchars($turno['apellido_medico'] . ", " . $turno['nombre_medico']) ?></td>
                <td><?= htmlspecialchars($turno['consultorio']) ?></td>
                <td><?= htmlspecialchars($turno['estado']) ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>