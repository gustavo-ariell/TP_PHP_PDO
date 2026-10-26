<?php
require_once "../conexion.php";

$fecha = $_POST["fecha"] ?? "";
$reservas = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $fecha !== "") {

    $sql = "SELECT
                r.id_reserva,
                r.fecha,
                r.estado,
                e.nombre AS nombre_estudiante,
                e.apellido AS apellido_estudiante,
                e.carrera,
                m.fecha AS fecha_menu,
                m.descripcion AS descripcion_menu,
                fp.nombre AS forma_pago
            FROM reserva r
            INNER JOIN estudiante e ON r.id_estudiante = e.id_estudiante
            INNER JOIN menu m ON r.id_menu = m.id_menu
            LEFT JOIN forma_pago fp ON r.id_forma_pago = fp.id_forma_pago
            WHERE r.fecha = :fecha
            ORDER BY e.apellido";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':fecha' => $fecha]);
    $reservas = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas por fecha</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE COMEDOR UNIVERSITARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="reservas_por_fecha.php">[ Por fecha ]</a>
        <a href="estudiantes_con_reservas.php">[ Estudiantes con reservas ]</a>
        <a href="platos_por_menu.php">[ Platos por menú ]</a>
        <a href="../reserva/listar.php">[ Reservas ]</a>
    </nav>
</header>

<main>

    <h2>Reservas por fecha</h2>

    <form action="reservas_por_fecha.php" method="post">

        <label for="fecha">Fecha <span class="requerido">*</span></label>
        <input type="date" name="fecha" id="fecha" required
               value="<?= htmlspecialchars($fecha) ?>">

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>

        <table>
            <tr>
                <th>Estudiante</th>
                <th>Carrera</th>
                <th>Menú</th>
                <th>Estado</th>
                <th>Forma de pago</th>
            </tr>
            <?php foreach ($reservas as $fila) { ?>
            <tr>
                <td><?= htmlspecialchars($fila['apellido_estudiante'] . ", " . $fila['nombre_estudiante']) ?></td>
                <td><?= htmlspecialchars((string)$fila['carrera']) ?></td>
                <td><?= htmlspecialchars($fila['fecha_menu'] . " — " . (string)$fila['descripcion_menu']) ?></td>
                <td><?= htmlspecialchars($fila['estado']) ?></td>
                <td><?= htmlspecialchars((string)$fila['forma_pago']) ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>