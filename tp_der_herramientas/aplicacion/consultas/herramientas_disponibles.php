<?php
require_once "../conexion.php";

$sql = "SELECT h.id_herramienta,
               h.nombre,
               h.codigo_interno,
               h.descripcion,
               c.nombre AS categoria
        FROM herramienta h
        LEFT JOIN categoria c ON h.id_categoria = c.id_categoria
        WHERE h.estado = 'disponible'
        ORDER BY c.nombre, h.nombre";

$herramientas = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Herramientas disponibles</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>CONSULTA: HERRAMIENTAS DISPONIBLES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="prestamos_activos.php">[ Préstamos activos ]</a>
        <a href="herramientas_pendientes.php">[ Pendientes de devolución ]</a>
    </nav>
</header>

<main>

    <h2>Herramientas disponibles para préstamo</h2>

    <?php if (count($herramientas) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($herramientas as $h): ?>
                    <tr>
                        <td><?= $h['id_herramienta'] ?></td>
                        <td><?= htmlspecialchars($h['codigo_interno']) ?></td>
                        <td><?= htmlspecialchars($h['nombre']) ?></td>
                        <td><?= htmlspecialchars($h['descripcion'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($h['categoria'] ?? '—') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">No hay herramientas disponibles en este momento.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Préstamos de Herramientas</p>
</footer>

</body>
</html>