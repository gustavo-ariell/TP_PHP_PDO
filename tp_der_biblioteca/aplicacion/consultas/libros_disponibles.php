<?php
require_once "../conexion.php";

$sql = "SELECT
            l.id_libro,
            l.titulo,
            l.cantidad_ejemplares,
            COUNT(p.id_prestamo) AS prestamos_activos,
            l.cantidad_ejemplares - COUNT(p.id_prestamo) AS disponibles
        FROM libro l
        LEFT JOIN prestamo p
            ON p.id_libro = l.id_libro
           AND p.fecha_devolucion_real IS NULL
        GROUP BY l.id_libro, l.titulo, l.cantidad_ejemplares
        HAVING disponibles > 0
        ORDER BY l.titulo";

$stmt = $pdo->query($sql);
$disponibles = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libros disponibles</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="libros_disponibles.php">[ Disponibles ]</a>
        <a href="libros_prestados.php">[ Prestados ]</a>
        <a href="prestamos_por_estudiante.php">[ Por estudiante ]</a>
        <a href="libros_autores.php">[ Libros y autores ]</a>
        <a href="../prestamo/listar.php">[ Préstamos ]</a>
    </nav>
</header>

<main>

    <h2>Libros disponibles</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Ejemplares totales</th>
            <th>Préstamos activos</th>
            <th>Ejemplares disponibles</th>
        </tr>
        <?php foreach ($disponibles as $libro) { ?>
        <tr>
            <td><?= $libro['id_libro'] ?></td>
            <td><?= htmlspecialchars($libro['titulo']) ?></td>
            <td><?= $libro['cantidad_ejemplares'] ?></td>
            <td><?= $libro['prestamos_activos'] ?></td>
            <td><?= $libro['disponibles'] ?></td>
        </tr>
        <?php } ?>
    </table>

</main>

</body>
</html>