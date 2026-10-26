<?php
require_once "../conexion.php";

$sql = "SELECT
            e.id_evento,
            e.nombre,
            e.fecha,
            e.horario,
            e.lugar,
            t.nombre AS tipo,
            COUNT(i.id_inscripcion) AS cantidad_inscritos
        FROM evento e
        INNER JOIN tipo_evento t ON e.id_tipo = t.id_tipo
        LEFT JOIN inscripcion_evento i ON e.id_evento = i.id_evento
        GROUP BY e.id_evento, e.nombre, e.fecha, e.horario, e.lugar, t.nombre
        ORDER BY e.fecha DESC";

$stmt = $pdo->query($sql);
$eventos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cantidad de inscritos por evento</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="asistentes_por_evento.php">[ Asistentes por evento ]</a>
        <a href="expositores_por_evento.php">[ Expositores por evento ]</a>
        <a href="cantidad_inscritos.php">[ Cantidad inscritos ]</a>
        <a href="../evento/listar.php">[ Eventos ]</a>
    </nav>
</header>

<main>

    <h2>Cantidad de inscritos por evento</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Evento</th>
            <th>Fecha</th>
            <th>Horario</th>
            <th>Lugar</th>
            <th>Tipo</th>
            <th>Inscritos</th>
        </tr>
        <?php foreach ($eventos as $fila) { ?>
        <tr>
            <td><?= $fila['id_evento'] ?></td>
            <td><?= htmlspecialchars($fila['nombre']) ?></td>
            <td><?= htmlspecialchars($fila['fecha']) ?></td>
            <td><?= htmlspecialchars($fila['horario']) ?></td>
            <td><?= htmlspecialchars((string)$fila['lugar']) ?></td>
            <td><?= htmlspecialchars($fila['tipo']) ?></td>
            <td><strong><?= $fila['cantidad_inscritos'] ?></strong></td>
        </tr>
        <?php } ?>
    </table>

</main>

</body>
</html>