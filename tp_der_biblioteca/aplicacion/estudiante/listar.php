<?php
require_once "../conexion.php";

$sql = "SELECT id_estudiante, nombre, apellido, dni, curso, telefono, email
        FROM estudiante
        ORDER BY apellido, nombre";

$stmt = $pdo->query($sql);
$estudiantes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de estudiantes</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Estudiantes ]</a>
        <a href="alta.php">[ Nuevo estudiante ]</a>
        <a href="../libro/listar.php">[ Libros ]</a>
        <a href="../prestamo/listar.php">[ Préstamos ]</a>
    </nav>
</header>

<main>

    <h2>Listado de estudiantes</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Curso</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($estudiantes as $estudiante) { ?>
        <tr>
            <td><?= $estudiante['id_estudiante'] ?></td>
            <td><?= htmlspecialchars($estudiante['nombre']) ?></td>
            <td><?= htmlspecialchars($estudiante['apellido']) ?></td>
            <td><?= htmlspecialchars($estudiante['dni']) ?></td>
            <td><?= htmlspecialchars((string)$estudiante['curso']) ?></td>
            <td><?= htmlspecialchars((string)$estudiante['telefono']) ?></td>
            <td><?= htmlspecialchars((string)$estudiante['email']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $estudiante['id_estudiante'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $estudiante['id_estudiante'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo estudiante</a></p>

</main>

</body>
</html>