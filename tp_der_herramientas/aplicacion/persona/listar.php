<?php
require_once "../conexion.php";

$personas = $pdo->query("SELECT * FROM persona ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar personas</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>PERSONAS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="alta.php">[ Registrar persona ]</a>
    </nav>
</header>

<main>

    <h2>Listado de personas</h2>

    <?php if (count($personas) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>DNI</th>
                    <th>Tipo</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($personas as $p): ?>
                    <tr>
                        <td><?= $p['id_persona'] ?></td>
                        <td><?= htmlspecialchars($p['nombre']) ?></td>
                        <td><?= htmlspecialchars($p['apellido']) ?></td>
                        <td><?= htmlspecialchars($p['dni']) ?></td>
                        <td><?= htmlspecialchars($p['tipo_persona']) ?></td>
                        <td><?= htmlspecialchars($p['telefono'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($p['email'] ?? '—') ?></td>
                        <td>
                            <a class="btn-editar" href="editar.php?id=<?= $p['id_persona'] ?>">Editar</a>
                            <a class="btn-eliminar" href="eliminar.php?id=<?= $p['id_persona'] ?>"
                               onclick="return confirm('¿Eliminar persona?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">No hay personas registradas.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Préstamos de Herramientas</p>
</footer>

</body>
</html>