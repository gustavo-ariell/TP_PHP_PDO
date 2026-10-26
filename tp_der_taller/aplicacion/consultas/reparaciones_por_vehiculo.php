<?php
require_once "../conexion.php";

$vehiculos = $pdo->query("SELECT id_vehiculo, patente, marca, modelo FROM vehiculo ORDER BY patente")->fetchAll();

$id_vehiculo = $_POST["id_vehiculo"] ?? "";
$reparaciones = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_vehiculo !== "") {

    $sql = "SELECT
                r.id_reparacion,
                r.fecha_ingreso,
                r.fecha_salida,
                r.diagnostico,
                r.estado,
                v.patente,
                v.marca,
                v.modelo,
                m.nombre AS nombre_mecanico,
                m.apellido AS apellido_mecanico
            FROM reparacion r
            INNER JOIN vehiculo v ON r.id_vehiculo = v.id_vehiculo
            INNER JOIN mecanico m ON r.id_mecanico = m.id_mecanico
            WHERE v.id_vehiculo = :id_vehiculo
            ORDER BY r.fecha_ingreso DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_vehiculo' => (int)$id_vehiculo]);
    $reparaciones = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reparaciones por vehículo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="reparaciones_por_vehiculo.php">[ Reparaciones por vehículo ]</a>
        <a href="servicios_por_reparacion.php">[ Servicios por reparación ]</a>
        <a href="vehiculos_por_cliente.php">[ Vehículos por cliente ]</a>
        <a href="../reparacion/listar.php">[ Reparaciones ]</a>
    </nav>
</header>

<main>

    <h2>Reparaciones por vehículo</h2>

    <form action="reparaciones_por_vehiculo.php" method="post">

        <label for="id_vehiculo">Vehículo <span class="requerido">*</span></label>
        <select name="id_vehiculo" id="id_vehiculo" required>
            <option value="">Seleccione un vehículo</option>
            <?php foreach ($vehiculos as $vehiculo) { ?>
                <option value="<?= $vehiculo['id_vehiculo'] ?>"
                    <?= $vehiculo['id_vehiculo'] == $id_vehiculo ? "selected" : "" ?>>
                    <?= htmlspecialchars($vehiculo['patente'] . " — " . $vehiculo['marca'] . " " . $vehiculo['modelo']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Fecha ingreso</th>
                <th>Fecha salida</th>
                <th>Diagnóstico</th>
                <th>Mecánico</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($reparaciones as $fila) { ?>
            <tr>
                <td><?= $fila['id_reparacion'] ?></td>
                <td><?= htmlspecialchars($fila['fecha_ingreso']) ?></td>
                <td><?= $fila['fecha_salida'] !== null ? htmlspecialchars($fila['fecha_salida']) : "—" ?></td>
                <td><?= htmlspecialchars((string)$fila['diagnostico']) ?></td>
                <td><?= htmlspecialchars($fila['apellido_mecanico'] . ", " . $fila['nombre_mecanico']) ?></td>
                <td><?= htmlspecialchars($fila['estado']) ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>