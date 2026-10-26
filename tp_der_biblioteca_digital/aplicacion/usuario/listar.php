<?php
require_once "../conexion.php";

$sql = "SELECT id_usuario, nombre, apellido, email, fecha_registro
        FROM usuario ORDER BY apellido, nombre";

$stmt = $pdo->query($sql);
$usuarios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de usuarios</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Usuarios ]</a>
        <a href="alta.php">[ Nuevo usuario ]</a>
        <a href="../libro/listar.php">[ Libros ]</a>
        <a href="../descarga/listar.php">[ Descargas ]</a>
    </nav>
</header>

<main>

    <h2>Listado de usuarios</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Fecha registro</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($usuarios as $usuario) { ?>
        <tr>
            <td><?= $usuario['id_usuario'] ?></td>
            <td><?= htmlspecialchars($usuario['nombre']) ?></td>
            <td><?= htmlspecialchars($usuario['apellido']) ?></td>
            <td><?= htmlspecialchars($usuario['email']) ?></td>
            <td><?= htmlspecialchars($usuario['fecha_registro']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $usuario['id_usuario'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $usuario['id_usuario'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo usuario</a></p>

</main>

</body>
</html>