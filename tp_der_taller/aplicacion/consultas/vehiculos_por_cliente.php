<?php
require_once "../conexion.php";

$clientes = $pdo->query("SELECT id_cliente, nombre, apellido, dni FROM cliente ORDER BY apellido")->fetchAll();

$id_cliente = $_POST["id_cliente"] ?? "";
$vehiculos = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_cliente !== "") {

    $sql = "SELECT
                v.patente,
                v.marca,
                v.modelo,
                v.anio,
                tv.nombre AS tipo,
                COUNT(r.id_reparacion) AS total_reparaciones
            FROM vehiculo v
            LEFT JOIN tipo_vehiculo tv ON v.id_tipo = tv.id_tipo
            LEFT JOIN reparacion r ON v.id_vehiculo = r.id_vehiculo
            WHERE v.id_cliente = :id_cliente
            GROUP BY v.id_vehiculo, v.patente, v.marca, v.modelo, v.anio, tv.nombre
            ORDER BY v.patente";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_cliente' => (int)$id_cliente]);
    $vehiculos = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vehículos por cliente</title>
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
        <a href="../vehiculo/listar.php">[ Vehículos ]</a>
    </nav>
</header>

<main>

    <h2>Vehículos por cliente</h2>

    <form action="vehiculos_por_cliente.php" method="post">

        <label for="id_cliente">Cliente <span class="requerido">*</span></label>
        <select name="id_cliente" id="id_cliente" required>
            <option value="">Seleccione un cliente</option>
            <?php foreach ($clientes as $cliente) { ?>
                <option value="<?= $cliente['id_cliente'] ?>"
                    <?= $cliente['id_cliente'] == $id_cliente ? "selected" : "" ?>>
                    <?= htmlspecialchars($cliente['apellido'] . ", " . $cliente['nombre'] . " (DNI: " . $cliente['dni'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>

        <table>
            <tr>
                <th>Patente</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Tipo</th>
                <th>Reparaciones</th>
            </tr>
            <?php foreach ($vehiculos as $fila) { ?>
            <tr>
                <td><?= htmlspecialchars($fila['patente']) ?></td>
                <td><?= htmlspecialchars($fila['marca']) ?></td>
                <td><?= htmlspecialchars($fila['modelo']) ?></td>
                <td><?= $fila['anio'] !== null ? $fila['anio'] : "—" ?></td>
                <td><?= htmlspecialchars((string)$fila['tipo']) ?></td>
                <td><?= $fila['total_reparaciones'] ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>