<?php
require_once "../conexion.php";

$autores = $pdo->query("SELECT * FROM autor ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar autores</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>AUTORES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="alta.php">[ Registrar autor ]</a>
    </nav>
</header>

<main>

    <h2>Listado de autores</h2>

    <?php if (count($autores) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Institución</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($autores as $a): ?>
                    <tr>
                        <td><?= $a['id_autor'] ?></td>
                        <td><?= htmlspecialchars($a['nombre']) ?></td>
                        <td><?= htmlspecialchars($a['apellido']) ?></td>
                        <td><?= htmlspecialchars($a['email'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($a['institucion'] ?? '—') ?></td>
                        <td>
                            <a class="btn-editar" href="editar.php?id=<?= $a['id_autor'] ?>">Editar</a>
                            <a class="btn-eliminar" href="eliminar.php?id=<?= $a['id_autor'] ?>"
                               onclick="return confirm('¿Eliminar autor?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">No hay autores registrados.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>