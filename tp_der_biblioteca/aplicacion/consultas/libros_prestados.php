<?php
require_once "../conexion.php";

$sql = "SELECT
            l.titulo,
            e.nombre,
            e.apellido,
            e.curso,
            p.fecha_prestamo,
            p.fecha_devolucion_estimada
        FROM prestamo p
        INNER JOIN libro l ON p.id_libro = l.id_libro
        INNER JOIN estudiante e ON p.id_estudiante = e.id_estudiante
        WHERE p.fecha_devolucion_real IS NULL
        ORDER BY p.fecha_devolucion_estimada";

$stmt = $pdo->query($sql);
$prestados = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libros prestados</title>
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

    <h2>Libros prestados</h2>

    <table>
        <tr>
            <th>Título</th>
            <th>Estudiante</th>
            <th>Curso</th>
            <th>Fecha de préstamo</th>
            <th>Devolución estimada</th>
        </tr>
        <?php foreach ($prestados as $prestado) { ?>
        <tr>
            <td><?= htmlspecialchars($prestado['titulo']) ?></td>
            <td><?= htmlspecialchars($prestado['nombre'] . " " . $prestado['apellido']) ?></td>
            <td><?= htmlspecialchars((string)$prestado['curso']) ?></td>
            <td><?= htmlspecialchars($prestado['fecha_prestamo']) ?></td>
            <td><?= htmlspecialchars((string)$prestado['fecha_devolucion_estimada']) ?></td>
        </tr>
        <?php } ?>
    </table>

</main>

</body>
</html>