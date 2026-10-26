<?php
require_once "../conexion.php";

$sql = "SELECT
            p.id_prestamo,
            p.fecha_prestamo,
            p.fecha_devolucion_estimada,
            p.fecha_devolucion_real,
            l.titulo,
            e.nombre,
            e.apellido
        FROM prestamo p
        INNER JOIN libro l ON p.id_libro = l.id_libro
        INNER JOIN estudiante e ON p.id_estudiante = e.id_estudiante
        ORDER BY p.fecha_prestamo DESC";

$stmt = $pdo->query($sql);
$prestamos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de préstamos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Préstamos ]</a>
        <a href="alta.php">[ Nuevo préstamo ]</a>
        <a href="devolucion.php">[ Devoluciones ]</a>
        <a href="../libro/listar.php">[ Libros ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
    </nav>
</header>

<main>

    <h2>Listado de préstamos</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Libro</th>
            <th>Estudiante</th>
            <th>Fecha préstamo</th>
            <th>Devolución estimada</th>
            <th>Devolución real</th>
            <th>Estado</th>
        </tr>
        <?php foreach ($prestamos as $prestamo) { ?>
        <tr>
            <td><?= $prestamo['id_prestamo'] ?></td>
            <td><?= htmlspecialchars($prestamo['titulo']) ?></td>
            <td><?= htmlspecialchars($prestamo['nombre'] . " " . $prestamo['apellido']) ?></td>
            <td><?= htmlspecialchars($prestamo['fecha_prestamo']) ?></td>
            <td><?= htmlspecialchars((string)$prestamo['fecha_devolucion_estimada']) ?></td>
            <td><?= htmlspecialchars((string)$prestamo['fecha_devolucion_real']) ?></td>
            <td>
                <?= $prestamo['fecha_devolucion_real'] === null ? "Pendiente" : "Devuelto" ?>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo préstamo</a></p>

</main>

</body>
</html>