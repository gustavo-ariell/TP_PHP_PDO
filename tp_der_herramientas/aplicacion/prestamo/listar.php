<?php
require_once "../conexion.php";

$sql = "SELECT pe.id_prestamo,
               pe.fecha_prestamo,
               pe.fecha_devolucion_estimada,
               pe.fecha_devolucion_real,
               pe.estado,
               pr.nombre AS persona_nombre,
               pr.apellido AS persona_apellido,
               pr.tipo_persona,
               COUNT(dp.id_detalle) AS cantidad_herramientas
        FROM prestamo pe
        INNER JOIN persona pr ON pe.id_persona = pr.id_persona
        LEFT JOIN detalle_prestamo dp ON pe.id_prestamo = dp.id_prestamo
        GROUP BY pe.id_prestamo, pe.fecha_prestamo, pe.fecha_devolucion_estimada,
                 pe.fecha_devolucion_real, pe.estado,
                 pr.nombre, pr.apellido, pr.tipo_persona
        ORDER BY pe.id_prestamo DESC";

$prestamos = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar préstamos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>PRÉSTAMOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="alta.php">[ Generar préstamo ]</a>
        <a href="devolver.php">[ Registrar devolución ]</a>
    </nav>
</header>

<main>

    <h2>Listado de préstamos</h2>

    <?php if (count($prestamos) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Persona</th>
                    <th>Tipo</th>
                    <th>Fecha préstamo</th>
                    <th>Dev. estimada</th>
                    <th>Dev. real</th>
                    <th>Estado</th>
                    <th>Herramientas</th>
                    <th>Acciones</th>
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
                        <td><?= htmlspecialchars($pe['fecha_devolucion_real'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($pe['estado']) ?></td>
                        <td><?= $pe['cantidad_herramientas'] ?></td>
                        <td>
                            <a class="btn-editar" href="agregar_herramienta.php?id=<?= $pe['id_prestamo'] ?>">Ver / Agregar</a>
                            <?php if ($pe['estado'] === 'activo' || $pe['estado'] === 'vencido'): ?>
                                <a class="btn-editar" href="devolver.php?id=<?= $pe['id_prestamo'] ?>">Devolver</a>
                            <?php endif; ?>
                            <a class="btn-eliminar" href="eliminar.php?id=<?= $pe['id_prestamo'] ?>"
                               onclick="return confirm('¿Eliminar préstamo?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">No hay préstamos registrados.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Préstamos de Herramientas</p>
</footer>

</body>
</html>