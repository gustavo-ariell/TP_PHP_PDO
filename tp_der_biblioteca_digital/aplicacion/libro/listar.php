<?php
require_once "../conexion.php";

$sql = "SELECT
            l.id_libro,
            l.titulo,
            l.descripcion,
            l.anio,
            l.archivo_digital,
            l.idioma,
            c.nombre AS categoria
        FROM libro_digital l
        LEFT JOIN categoria c ON l.id_categoria = c.id_categoria
        ORDER BY l.titulo";

$stmt = $pdo->query($sql);
$libros = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de libros digitales</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Libros ]</a>
        <a href="alta.php">[ Nuevo libro ]</a>
        <a href="asociar.php">[ Asociar autores ]</a>
        <a href="../autor/listar.php">[ Autores ]</a>
        <a href="../usuario/listar.php">[ Usuarios ]</a>
        <a href="../descarga/listar.php">[ Descargas ]</a>
    </nav>
</header>

<main>

    <h2>Listado de libros digitales</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Año</th>
            <th>Archivo</th>
            <th>Idioma</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($libros as $libro) { ?>
        <tr>
            <td><?= $libro['id_libro'] ?></td>
            <td><?= htmlspecialchars($libro['titulo']) ?></td>
            <td><?= htmlspecialchars((string)$libro['descripcion']) ?></td>
            <td><?= $libro['anio'] !== null ? $libro['anio'] : "—" ?></td>
            <td><?= htmlspecialchars((string)$libro['archivo_digital']) ?></td>
            <td><?= htmlspecialchars((string)$libro['idioma']) ?></td>
            <td><?= htmlspecialchars((string)$libro['categoria']) ?></td>
            <td>
                <a class="btn-editar" href="asociar.php?id=<?= $libro['id_libro'] ?>">Autores</a>
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