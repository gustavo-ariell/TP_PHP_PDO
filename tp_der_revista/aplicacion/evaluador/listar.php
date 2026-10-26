<?php
require_once "../conexion.php";

$evaluadores = $pdo->query("SELECT * FROM evaluador ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar evaluadores</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>EVALUADORES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="alta.php">[ Registrar evaluador ]</a>
    </nav>
</header>

<main>

    <h2>Listado de evaluadores</h2>

    <?php if (count($evaluadores) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Especialidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($evaluadores as $e): ?>
                    <tr>
                        <td><?= $e['id_evaluador'] ?></td>
                        <td><?= htmlspecialchars($e['nombre']) ?></td>
                        <td><?= htmlspecialchars($e['apellido']) ?></td>
                        <td><?= htmlspecialchars($e['email'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($e['especialidad'] ?? '—') ?></td>
                        <td>
                            <a class="btn-editar" href="editar.php?id=<?= $e['id_evaluador'] ?>">Editar</a>
                            <a class="btn-eliminar" href="eliminar.php?id=<?= $e['id_evaluador'] ?>"
                               onclick="return confirm('¿Eliminar evaluador?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">No hay evaluadores registrados.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>