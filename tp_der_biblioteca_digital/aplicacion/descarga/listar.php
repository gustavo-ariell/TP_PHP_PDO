<?php
require_once "../conexion.php";

$sql = "SELECT
            d.id_descarga,
            d.fecha_descarga,
            d.dispositivo,
            u.nombre AS nombre_usuario,
            u.apellido AS apellido_usuario,
            u.email,
            l.titulo
        FROM descarga d
        INNER JOIN usuario u ON d.id_usuario = u.id_usuario
        INNER JOIN libro_digital l ON d.id_libro = l.id_libro
        ORDER BY d.fecha_descarga DESC";

$stmt = $pdo->query($sql);
$descargas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de descargas</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Descargas ]</a>
        <a href="alta.php">[ Nueva descarga ]</a>
        <a href="../libro/listar.php">[ Libros ]</a>
        <a href="../usuario/listar.php">[ Usuarios ]</a>
    </nav>
</header>

<main>

    <h2>Listado de descargas</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Libro</th>
            <th>Fecha y hora</th>
            <th>Dispositivo</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($descargas as $descarga) { ?>
        <tr>
            <td><?= $descarga['id_descarga'] ?></td>
            <td><?= htmlspecialchars($descarga['apellido_usuario'] . ", " . $descarga['nombre_usuario']) ?></td>
            <td><?= htmlspecialchars($descarga['email']) ?></td>
            <td><?= htmlspecialchars($descarga['titulo']) ?></td>
            <td><?= htmlspecialchars($descarga['fecha_descarga']) ?></td>
            <td><?= htmlspecialchars((string)$descarga['dispositivo']) ?></td>
            <td>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $descarga['id_descarga'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar una nueva descarga</a></p>

</main>

</body>
</html>