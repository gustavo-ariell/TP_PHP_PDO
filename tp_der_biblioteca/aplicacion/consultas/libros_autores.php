<?php
require_once "../conexion.php";

$sql = "SELECT
            l.titulo,
            a.nombre,
            a.apellido
        FROM libro l
        INNER JOIN libro_autor la ON l.id_libro = la.id_libro
        INNER JOIN autor a ON la.id_autor = a.id_autor
        ORDER BY l.titulo";

$stmt = $pdo->query($sql);
$relacion = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libros y autores</title>
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

    <h2>Consulta relacionada: libros y autores (INNER JOIN)</h2>

    <table>
        <tr>
            <th>Título</th>
            <th>Nombre del autor</th>
            <th>Apellido del autor</th>
        </tr>
        <?php foreach ($relacion as $fila) { ?>
        <tr>
            <td><?= htmlspecialchars($fila['titulo']) ?></td>
            <td><?= htmlspecialchars($fila['nombre']) ?></td>
            <td><?= htmlspecialchars($fila['apellido']) ?></td>
        </tr>
        <?php } ?>
    </table>

</main>

</body>
</html>