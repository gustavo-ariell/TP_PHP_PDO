<?php
require_once "../conexion.php";

$sql = "SELECT
            l.id_libro,
            l.titulo,
            l.isbn,
            l.anio_publicacion,
            l.cantidad_ejemplares,
            c.nombre AS categoria,
            e.nombre AS editorial
        FROM libro l
        INNER JOIN categoria c ON l.id_categoria = c.id_categoria
        INNER JOIN editorial e ON l.id_editorial = e.id_editorial
        ORDER BY l.titulo";

$stmt = $pdo->query($sql);
$libros = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de libros</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Libros ]</a>
        <a href="alta.php">[ Nuevo libro ]</a>
        <a href="../autor/listar.php">[ Autores ]</a>
        <a href="../editorial/listar.php">[ Editoriales ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
        <a href="../prestamo/listar.php">[ Préstamos ]</a>
        <a href="../consultas/libros_disponibles.php">[ Consultas ]</a>
    </nav>
</header>

<main>

    <h2>Listado de libros</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>ISBN</th>
            <th>Año</th>
            <th>Ejemplares</th>
            <th>Categoría</th>
            <th>Editorial</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($libros as $libro) { ?>
        <tr>
            <td><?= $libro['id_libro'] ?></td>
            <td><?= htmlspecialchars($libro['titulo']) ?></td>
            <td><?= htmlspecialchars($libro['isbn']) ?></td>
            <td><?= htmlspecialchars((string)$libro['anio_publicacion']) ?></td>
            <td><?= $libro['cantidad_ejemplares'] ?></td>
            <td><?= htmlspecialchars($libro['categoria']) ?></td>
            <td><?= htmlspecialchars($libro['editorial']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $libro['id_libro'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $libro['id_libro'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo libro</a></p>

</main>

</body>
</html>