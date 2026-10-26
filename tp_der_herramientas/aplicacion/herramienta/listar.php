<?php
require_once "../conexion.php";

$sql = "SELECT h.id_herramienta,
               h.nombre,
               h.descripcion,
               h.codigo_interno,
               h.estado,
               c.nombre AS categoria
        FROM herramienta h
        LEFT JOIN categoria c ON h.id_categoria = c.id_categoria
        ORDER BY h.nombre";

$herramientas = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar herramientas</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>HERRAMIENTAS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="alta.php">[ Registrar herramienta ]</a>
    </nav>
</header>

<main>

    <h2>Listado de herramientas</h2>

    <?php if (count($herramientas) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Acciones</th>
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
                        <td><?= htmlspecialchars($h['estado']) ?></td>
                        <td>
                            <a class="btn-editar" href="editar.php?id=<?= $h['id_herramienta'] ?>">Editar</a>
                            <a class="btn-eliminar" href="eliminar.php?id=<?= $h['id_herramienta'] ?>"
                               onclick="return confirm('¿Eliminar herramienta?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">No hay herramientas registradas.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Préstamos de Herramientas</p>
</footer>

</body>
</html>