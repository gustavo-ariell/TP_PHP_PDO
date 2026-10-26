<?php
require_once "../conexion.php";

$sql = "SELECT id_autor, nombre, apellido, nacionalidad
        FROM autor ORDER BY apellido, nombre";

$stmt = $pdo->query($sql);
$autores = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de autores</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Autores ]</a>
        <a href="alta.php">[ Nuevo autor ]</a>
        <a href="../libro/listar.php">[ Libros ]</a>
        <a href="../usuario/listar.php">[ Usuarios ]</a>
    </nav>
</header>

<main>

    <h2>Listado de autores</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Nacionalidad</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($autores as $autor) { ?>
        <tr>
            <td><?= $autor['id_autor'] ?></td>
            <td><?= htmlspecialchars($autor['nombre']) ?></td>
            <td><?= htmlspecialchars($autor['apellido']) ?></td>
            <td><?= htmlspecialchars((string)$autor['nacionalidad']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $autor['id_autor'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $autor['id_autor'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo autor</a></p>

</main>

</body>
</html>