<?php
require_once "../conexion.php";

$sql = "SELECT
            e.id_evento,
            e.nombre,
            e.descripcion,
            e.fecha,
            e.horario,
            e.lugar,
            t.nombre AS tipo
        FROM evento e
        INNER JOIN tipo_evento t ON e.id_tipo = t.id_tipo
        ORDER BY e.fecha DESC";

$stmt = $pdo->query($sql);
$eventos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de eventos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Eventos ]</a>
        <a href="alta.php">[ Nuevo evento ]</a>
        <a href="asociar.php">[ Asociar expositores ]</a>
        <a href="../expositor/listar.php">[ Expositores ]</a>
        <a href="../asistente/listar.php">[ Asistentes ]</a>
        <a href="../inscripcion/listar.php">[ Inscripciones ]</a>
    </nav>
</header>

<main>

    <h2>Listado de eventos</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha</th>
            <th>Horario</th>
            <th>Lugar</th>
            <th>Tipo</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($eventos as $evento) { ?>
        <tr>
            <td><?= $evento['id_evento'] ?></td>
            <td><?= htmlspecialchars($evento['nombre']) ?></td>
            <td><?= htmlspecialchars((string)$evento['descripcion']) ?></td>
            <td><?= htmlspecialchars($evento['fecha']) ?></td>
            <td><?= htmlspecialchars($evento['horario']) ?></td>
            <td><?= htmlspecialchars((string)$evento['lugar']) ?></td>
            <td><?= htmlspecialchars($evento['tipo']) ?></td>
            <td>
                <a class="btn-editar" href="asociar.php?id=<?= $evento['id_evento'] ?>">Expositores</a>
                <a class="btn-editar" href="editar.php?id=<?= $evento['id_evento'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $evento['id_evento'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo evento</a></p>

</main>

</body>
</html>