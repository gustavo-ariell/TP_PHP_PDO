<?php
require_once "../conexion.php";

$sql = "SELECT id_editorial, nombre, direccion, telefono
        FROM editorial
        ORDER BY nombre";

$stmt = $pdo->query($sql);
$editoriales = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de editoriales</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Editoriales ]</a>
        <a href="alta.php">[ Nueva editorial ]</a>
        <a href="../libro/listar.php">[ Libros ]</a>
        <a href="../autor/listar.php">[ Autores ]</a>
        <a href="../prestamo/listar.php">[ Préstamos ]</a>
    </nav>
</header>

<main>

    <h2>Listado de editoriales</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($editoriales as $editorial) { ?>
        <tr>
            <td><?= $editorial['id_editorial'] ?></td>
            <td><?= htmlspecialchars($editorial['nombre']) ?></td>
            <td><?= htmlspecialchars((string)$editorial['direccion']) ?></td>
            <td><?= htmlspecialchars((string)$editorial['telefono']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $editorial['id_editorial'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $editorial['id_editorial'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar una nueva editorial</a></p>

</main>

</body>
</html>