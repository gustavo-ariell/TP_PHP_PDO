<?php
require_once "../conexion.php";

$sql = "SELECT h.id_herramienta,
               h.nombre,
               h.codigo_interno,
               h.estado,
               c.nombre AS categoria,
               pe.id_prestamo,
               pe.fecha_prestamo,
               pe.fecha_devolucion_estimada,
               pe.estado AS estado_prestamo,
               pr.nombre AS persona_nombre,
               pr.apellido AS persona_apellido
        FROM detalle_prestamo dp
        INNER JOIN herramienta h ON dp.id_herramienta = h.id_herramienta
        INNER JOIN prestamo pe ON dp.id_prestamo = pe.id_prestamo
        INNER JOIN persona pr ON pe.id_persona = pr.id_persona
        LEFT JOIN categoria c ON h.id_categoria = c.id_categoria
        WHERE pe.estado IN ('activo', 'vencido')
        ORDER BY pe.fecha_devolucion_estimada";

$pendientes = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Herramientas pendientes de devolución</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>CONSULTA: HERRAMIENTAS PENDIENTES DE DEVOLUCIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="prestamos_activos.php">[ Préstamos activos ]</a>
        <a href="herramientas_disponibles.php">[ Herramientas disponibles ]</a>
    </nav>
</header>

<main>

    <h2>Herramientas que deben ser devueltas</h2>

    <?php if (count($pendientes) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Herramienta</th>
                    <th>Categoría</th>
                    <th>Préstamo</th>
                    <th>Persona</th>
                    <th>Fecha préstamo</th>
                    <th>Dev. estimada</th>
                    <th>Estado préstamo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pendientes as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['codigo_interno']) ?></td>
                        <td><?= htmlspecialchars($p['nombre']) ?></td>
                        <td><?= htmlspecialchars($p['categoria'] ?? '—') ?></td>
                        <td>#<?= $p['id_prestamo'] ?></td>
                        <td><?= htmlspecialchars($p['persona_apellido'] . ", " . $p['persona_nombre']) ?></td>
                        <td><?= htmlspecialchars($p['fecha_prestamo']) ?></td>
                        <td><?= htmlspecialchars($p['fecha_devolucion_estimada'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($p['estado_prestamo']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje exito">No hay herramientas pendientes de devolución.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Préstamos de Herramientas</p>
</footer>

</body>
</html>