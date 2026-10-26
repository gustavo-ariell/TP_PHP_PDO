<?php
require_once "../conexion.php";

$sql = "SELECT ev.id_evaluacion,
               ev.fecha,
               ev.dictamen,
               ev.observaciones,
               ar.titulo AS articulo,
               eva.nombre AS eval_nombre,
               eva.apellido AS eval_apellido,
               eva.especialidad
        FROM evaluacion ev
        INNER JOIN articulo ar ON ev.id_articulo = ar.id_articulo
        INNER JOIN evaluador eva ON ev.id_evaluador = eva.id_evaluador
        ORDER BY ev.id_evaluacion DESC";

$evaluaciones = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar evaluaciones</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>EVALUACIONES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="alta.php">[ Registrar evaluación ]</a>
    </nav>
</header>

<main>

    <h2>Listado de evaluaciones</h2>

    <?php if (count($evaluaciones) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Artículo</th>
                    <th>Evaluador</th>
                    <th>Especialidad</th>
                    <th>Fecha</th>
                    <th>Dictamen</th>
                    <th>Observaciones</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($evaluaciones as $ev): ?>
                    <tr>
                        <td><?= $ev['id_evaluacion'] ?></td>
                        <td><?= htmlspecialchars($ev['articulo']) ?></td>
                        <td><?= htmlspecialchars($ev['eval_apellido'] . ", " . $ev['eval_nombre']) ?></td>
                        <td><?= htmlspecialchars($ev['especialidad'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($ev['fecha']) ?></td>
                        <td><?= htmlspecialchars($ev['dictamen']) ?></td>
                        <td><?= htmlspecialchars($ev['observaciones'] ?? '—') ?></td>
                        <td>
                            <a class="btn-eliminar" href="eliminar.php?id=<?= $ev['id_evaluacion'] ?>"
                               onclick="return confirm('¿Eliminar evaluación?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">No hay evaluaciones registradas.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>