<?php
require_once "../conexion.php";

$secciones = $pdo->query("SELECT * FROM seccion ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar secciones</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SECCIONES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="alta.php">[ Registrar sección ]</a>
    </nav>
</header>

<main>

    <h2>Listado de secciones</h2>

    <?php if (count($secciones) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($secciones as $s): ?>
                    <tr>
                        <td><?= $s['id_seccion'] ?></td>
                        <td><?= htmlspecialchars($s['nombre']) ?></td>
                        <td><?= htmlspecialchars($s['descripcion'] ?? '—') ?></td>
                        <td>
                            <a class="btn-eliminar"
                               href="eliminar.php?id=<?= $s['id_seccion'] ?>"
                               onclick="return confirm('¿Eliminar sección?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">No hay secciones registradas.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>