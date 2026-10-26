<?php
require_once "../conexion.php";

$sql = "SELECT d.id_docente, d.nombre, d.apellido, d.email,
               i.nombre AS instrumento
        FROM docente d
        INNER JOIN instrumento i ON d.id_instrumento = i.id_instrumento
        ORDER BY d.apellido";

$docentes = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar docentes</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>DOCENTES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="alta.php">[ Registrar docente ]</a>
    </nav>
</header>

<main>

    <h2>Listado de docentes</h2>

    <?php if (count($docentes) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Instrumento</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($docentes as $doc): ?>
                    <tr>
                        <td><?= $doc['id_docente'] ?></td>
                        <td><?= htmlspecialchars($doc['nombre']) ?></td>
                        <td><?= htmlspecialchars($doc['apellido']) ?></td>
                        <td><?= htmlspecialchars($doc['instrumento']) ?></td>
                        <td><?= htmlspecialchars($doc['email'] ?? '—') ?></td>
                        <td>
                            <a class="btn-editar" href="editar.php?id=<?= $doc['id_docente'] ?>">Editar</a>
                            <a class="btn-eliminar" href="eliminar.php?id=<?= $doc['id_docente'] ?>"
                               onclick="return confirm('¿Eliminar docente?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">No hay docentes registrados.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>