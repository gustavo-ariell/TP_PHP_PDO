<?php
require_once "../conexion.php";

$sql = "SELECT ar.id_articulo,
               ar.titulo,
               ar.fecha_envio,
               ar.palabras_clave,
               s.nombre AS seccion,
               e.nombre AS estado
        FROM articulo ar
        INNER JOIN seccion s ON ar.id_seccion = s.id_seccion
        INNER JOIN estado_articulo e ON ar.id_estado = e.id_estado
        ORDER BY ar.id_articulo DESC";

$articulos = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar artículos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>ARTÍCULOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="alta.php">[ Registrar artículo ]</a>
        <a href="cambiar_estado.php">[ Cambiar estado ]</a>
        <a href="asociar_autor.php">[ Asociar autores ]</a>
        <a href="asociar_evaluador.php">[ Asociar evaluadores ]</a>
    </nav>
</header>

<main>

    <h2>Listado de artículos</h2>

    <?php if (count($articulos) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Fecha envío</th>
                    <th>Sección</th>
                    <th>Estado</th>
                    <th>Palabras clave</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articulos as $a): ?>
                    <tr>
                        <td><?= $a['id_articulo'] ?></td>
                        <td><?= htmlspecialchars($a['titulo']) ?></td>
                        <td><?= htmlspecialchars($a['fecha_envio']) ?></td>
                        <td><?= htmlspecialchars($a['seccion']) ?></td>
                        <td><?= htmlspecialchars($a['estado']) ?></td>
                        <td><?= htmlspecialchars($a['palabras_clave'] ?? '—') ?></td>
                        <td>
                            <a class="btn-editar" href="cambiar_estado.php?id=<?= $a['id_articulo'] ?>">Estado</a>
                            <a class="btn-eliminar" href="eliminar.php?id=<?= $a['id_articulo'] ?>"
                               onclick="return confirm('¿Eliminar artículo?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">No hay artículos registrados.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>