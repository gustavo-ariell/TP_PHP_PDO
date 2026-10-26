<?php
require_once "../conexion.php";

$sql = "SELECT
            c.id_curso,
            c.nombre,
            c.descripcion,
            c.duracion,
            c.modalidad,
            d.nombre AS nombre_docente,
            d.apellido AS apellido_docente
        FROM curso c
        INNER JOIN docente d ON c.id_docente = d.id_docente
        ORDER BY c.nombre";

$stmt = $pdo->query($sql);
$cursos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de cursos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE CURSOS DE CAPACITACIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Cursos ]</a>
        <a href="alta.php">[ Nuevo curso ]</a>
        <a href="../docente/listar.php">[ Docentes ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
        <a href="../inscripcion/listar.php">[ Inscripciones ]</a>
    </nav>
</header>

<main>

    <h2>Listado de cursos</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Duración</th>
            <th>Modalidad</th>
            <th>Docente</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($cursos as $curso) { ?>
        <tr>
            <td><?= $curso['id_curso'] ?></td>
            <td><?= htmlspecialchars($curso['nombre']) ?></td>
            <td><?= htmlspecialchars((string)$curso['descripcion']) ?></td>
            <td><?= htmlspecialchars((string)$curso['duracion']) ?></td>
            <td><?= htmlspecialchars((string)$curso['modalidad']) ?></td>
            <td><?= htmlspecialchars($curso['apellido_docente'] . ", " . $curso['nombre_docente']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $curso['id_curso'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $curso['id_curso'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo curso</a></p>

</main>

</body>
</html>