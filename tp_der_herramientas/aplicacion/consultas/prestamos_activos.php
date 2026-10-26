<?php
require_once "../conexion.php";

$sql = "SELECT pe.id_prestamo,
               pe.fecha_prestamo,
               pe.fecha_devolucion_estimada,
               pe.estado,
               pr.nombre AS persona_nombre,
               pr.apellido AS persona_apellido,
               pr.tipo_persona,
               COUNT(dp.id_detalle) AS cantidad_herramientas
        FROM prestamo pe
        INNER JOIN persona pr ON pe.id_persona = pr.id_persona
        LEFT JOIN detalle_prestamo dp ON pe.id_prestamo = dp.id_prestamo
        WHERE pe.estado IN ('activo', 'vencido')
        GROUP BY pe.id_prestamo
        ORDER BY pe.fecha_prestamo";

$prestamos = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Préstamos activos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>CONSULTA: PRÉSTAMOS ACTIVOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="herramientas_disponibles.php">[ Herramientas disponibles ]</a>
        <a href="herramientas_pendientes.php">[ Pendientes de devolución ]</a>
    </nav>
</header>

<main>

    <h2>Préstamos activos y vencidos</h2>

    <?php if (count($prestamos) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Persona</th>
                    <th>Tipo</th>
                    <th>Fecha préstamo</th>
                    <th>Dev. estimada</th>
                    <th>Estado</th>
                    <th>Herramientas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prestamos as $pe): ?>
                    <tr>
                        <td><?= $pe['id_prestamo'] ?></td>
                        <td><?= htmlspecialchars($pe['persona_apellido'] . ", " . $pe['persona_nombre']) ?></td>
                        <td><?= htmlspecialchars($pe['tipo_persona']) ?></td>
                        <td><?= htmlspecialchars($pe['fecha_prestamo']) ?></td>
                        <td><?= htmlspecialchars($pe['fecha_devolucion_estimada'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($pe['estado']) ?></td>
                        <td><?= $pe['cantidad_herramientas'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje exito">No hay préstamos activos ni vencidos.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Préstamos de Herramientas</p>
</footer>

</body>
</html>