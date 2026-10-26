<?php
require_once "../conexion.php";

$sql = "SELECT
            e.nombre,
            e.apellido,
            e.dni,
            e.carrera,
            COUNT(r.id_reserva) AS total_reservas,
            SUM(CASE WHEN r.estado = 'confirmada' THEN 1 ELSE 0 END) AS confirmadas,
            SUM(CASE WHEN r.estado = 'pendiente' THEN 1 ELSE 0 END) AS pendientes,
            SUM(CASE WHEN r.estado = 'cancelada' THEN 1 ELSE 0 END) AS canceladas
        FROM estudiante e
        INNER JOIN reserva r ON e.id_estudiante = r.id_estudiante
        GROUP BY e.id_estudiante, e.nombre, e.apellido, e.dni, e.carrera
        ORDER BY e.apellido, e.nombre";

$stmt = $pdo->query($sql);
$estudiantes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudiantes con reservas</title>
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

    <h2>Estudiantes con reservas</h2>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Carrera</th>
            <th>Total reservas</th>
            <th>Confirmadas</th>
            <th>Pendientes</th>
            <th>Canceladas</th>
        </tr>
        <?php foreach ($estudiantes as $fila) { ?>
        <tr>
            <td><?= htmlspecialchars($fila['nombre']) ?></td>
            <td><?= htmlspecialchars($fila['apellido']) ?></td>
            <td><?= htmlspecialchars($fila['dni']) ?></td>
            <td><?= htmlspecialchars((string)$fila['carrera']) ?></td>
            <td><?= $fila['total_reservas'] ?></td>
            <td><?= $fila['confirmadas'] ?></td>
            <td><?= $fila['pendientes'] ?></td>
            <td><?= $fila['canceladas'] ?></td>
        </tr>
        <?php } ?>
    </table>

</main>

</body>
</html>