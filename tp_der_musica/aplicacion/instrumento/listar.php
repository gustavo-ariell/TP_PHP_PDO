<?php
require_once "../conexion.php";

$instrumentos = $pdo->query("SELECT * FROM instrumento ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar instrumentos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>INSTRUMENTOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="alta.php">[ Registrar instrumento ]</a>
    </nav>
</header>

<main>

    <h2>Listado de instrumentos</h2>

    <table>
        <thead>
            <tr><th>ID</th><th>Nombre</th><th>Acción</th></tr>
        </thead>
        <tbody>
            <?php foreach ($instrumentos as $inst): ?>
                <tr>
                    <td><?= $inst['id_instrumento'] ?></td>
                    <td><?= htmlspecialchars($inst['nombre']) ?></td>
                    <td>
                        <a class="btn-eliminar" href="eliminar.php?id=<?= $inst['id_instrumento'] ?>"
                           onclick="return confirm('¿Eliminar instrumento?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>