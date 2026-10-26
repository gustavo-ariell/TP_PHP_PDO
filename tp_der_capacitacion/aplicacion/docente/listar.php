<?php
require_once "../conexion.php";

$sql = "SELECT id_docente, nombre, apellido, dni, email, telefono
        FROM docente ORDER BY apellido, nombre";

$stmt = $pdo->query($sql);
$docentes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de docentes</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE CURSOS DE CAPACITACIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Docentes ]</a>
        <a href="alta.php">[ Nuevo docente ]</a>
        <a href="../curso/listar.php">[ Cursos ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
        <a href="../inscripcion/listar.php">[ Inscripciones ]</a>
    </nav>
</header>

<main>

    <h2>Listado de docentes</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($docentes as $docente) { ?>
        <tr>
            <td><?= $docente['id_docente'] ?></td>
            <td><?= htmlspecialchars($docente['nombre']) ?></td>
            <td><?= htmlspecialchars($docente['apellido']) ?></td>
            <td><?= htmlspecialchars($docente['dni']) ?></td>
            <td><?= htmlspecialchars((string)$docente['email']) ?></td>
            <td><?= htmlspecialchars((string)$docente['telefono']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $docente['id_docente'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $docente['id_docente'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo docente</a></p>

</main>

</body>
</html>