<?php
require_once "../conexion.php";

$fecha = $_POST["fecha"] ?? "";
$turnos = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $fecha !== "") {

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
            WHERE t.fecha = :fecha
            ORDER BY t.hora";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':fecha' => $fecha]);
    $turnos = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Turnos por fecha</title>
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

    <h2>Turnos por fecha</h2>

    <form action="turnos_por_fecha.php" method="post">

        <label for="fecha">Fecha <span class="requerido">*</span></label>
        <input type="date" name="fecha" id="fecha" required
               value="<?= htmlspecialchars($fecha) ?>">

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>

        <table>
            <tr>
                <th>Hora</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Consultorio</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($turnos as $turno) { ?>
            <tr>
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