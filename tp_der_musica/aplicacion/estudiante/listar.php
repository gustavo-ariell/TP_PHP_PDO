<?php
require_once "../conexion.php";

$sql = "SELECT * FROM estudiante ORDER BY apellido";
$estudiantes = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar estudiantes</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>ESTUDIANTES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="alta.php">[ Registrar estudiante ]</a>
    </nav>
</header>

<main>

    <h2>Listado de estudiantes</h2>

    <?php if (count($estudiantes) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>DNI</th>
                    <th>Edad</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estudiantes as $est): ?>
                    <tr>
                        <td><?= $est['id_estudiante'] ?></td>
                        <td><?= htmlspecialchars($est['nombre']) ?></td>
                        <td><?= htmlspecialchars($est['apellido']) ?></td>
                        <td><?= htmlspecialchars($est['dni']) ?></td>
                        <td><?= $est['edad'] !== null ? $est['edad'] : '—' ?></td>
                        <td><?= htmlspecialchars($est['telefono'] ?? '—') ?></td>
                        <td>
                            <a class="btn-editar" href="editar.php?id=<?= $est['id_estudiante'] ?>">Editar</a>
                            <a class="btn-eliminar" href="eliminar.php?id=<?= $est['id_estudiante'] ?>"
                               onclick="return confirm('¿Eliminar estudiante?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">No hay estudiantes registrados.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>