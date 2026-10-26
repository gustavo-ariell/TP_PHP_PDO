<?php
require_once "../conexion.php";

$categorias = $pdo->query("SELECT * FROM categoria ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar categorías</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>CATEGORÍAS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="alta.php">[ Registrar categoría ]</a>
    </nav>
</header>

<main>

    <h2>Listado de categorías</h2>

    <table>
        <thead>
            <tr><th>ID</th><th>Nombre</th><th>Acción</th></tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $c): ?>
                <tr>
                    <td><?= $c['id_categoria'] ?></td>
                    <td><?= htmlspecialchars($c['nombre']) ?></td>
                    <td>
                        <a class="btn-eliminar" href="eliminar.php?id=<?= $c['id_categoria'] ?>"
                           onclick="return confirm('¿Eliminar categoría?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Préstamos de Herramientas</p>
</footer>

</body>
</html>