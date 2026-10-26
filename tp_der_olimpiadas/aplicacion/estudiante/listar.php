<?php
require_once "../conexion.php";

$sql = "SELECT
            e.id_estudiante,
            e.nombre,
            e.apellido,
            e.dni,
            e.direccion,
            c.nombre AS curso,
            d.nombre AS division,
            l.nombre AS localidad,
            p.nombre AS provincia,
            pa.nombre AS pais
        FROM estudiante e
        LEFT JOIN curso c ON e.id_curso = c.id_curso
        LEFT JOIN division d ON e.id_division = d.id_division
        LEFT JOIN localidad l ON e.id_localidad = l.id_localidad
        LEFT JOIN provincia p ON e.id_provincia = p.id_provincia
        LEFT JOIN pais pa ON e.id_pais = pa.id_pais
        ORDER BY e.apellido, e.nombre";

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
    <h1>SISTEMA DE INSCRIPCIÓN A OLIMPIADAS ESCOLARES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Estudiantes ]</a>
        <a href="alta.php">[ Nuevo estudiante ]</a>
        <a href="../disciplina/listar.php">[ Disciplinas ]</a>
        <a href="../inscripcion/listar.php">[ Inscripciones ]</a>
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
            <th>Dirección</th>
            <th>Curso</th>
            <th>División</th>
            <th>Localidad</th>
            <th>Provincia</th>
            <th>País</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($estudiantes as $estudiante) { ?>
        <tr>
            <td><?= $estudiante['id_estudiante'] ?></td>
            <td><?= htmlspecialchars($estudiante['nombre']) ?></td>
            <td><?= htmlspecialchars($estudiante['apellido']) ?></td>
            <td><?= htmlspecialchars($estudiante['dni']) ?></td>
            <td><?= htmlspecialchars((string)$estudiante['direccion']) ?></td>
            <td><?= htmlspecialchars((string)$estudiante['curso']) ?></td>
            <td><?= htmlspecialchars((string)$estudiante['division']) ?></td>
            <td><?= htmlspecialchars((string)$estudiante['localidad']) ?></td>
            <td><?= htmlspecialchars((string)$estudiante['provincia']) ?></td>
            <td><?= htmlspecialchars((string)$estudiante['pais']) ?></td>
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