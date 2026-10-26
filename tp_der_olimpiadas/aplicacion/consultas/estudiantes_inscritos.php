<?php
require_once "../conexion.php";

$sql = "SELECT
            e.nombre,
            e.apellido,
            e.dni,
            d.nombre AS disciplina,
            i.fecha_inscripcion,
            i.anio_participacion,
            i.estado
        FROM inscripcion i
        INNER JOIN estudiante e ON i.id_estudiante = e.id_estudiante
        INNER JOIN disciplina d ON i.id_disciplina = d.id_disciplina
        ORDER BY e.apellido, e.nombre, d.nombre";

$stmt = $pdo->query($sql);
$inscritos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudiantes inscritos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE INSCRIPCIÓN A OLIMPIADAS ESCOLARES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="estudiantes_inscritos.php">[ Inscritos ]</a>
        <a href="participantes_por_disciplina.php">[ Por disciplina ]</a>
        <a href="participantes_por_curso.php">[ Por curso ]</a>
        <a href="participantes_por_provincia.php">[ Por provincia ]</a>
        <a href="../inscripcion/listar.php">[ Inscripciones ]</a>
    </nav>
</header>

<main>

    <h2>Estudiantes inscritos</h2>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Disciplina</th>
            <th>Fecha inscripción</th>
            <th>Año</th>
            <th>Estado</th>
        </tr>
        <?php foreach ($inscritos as $fila) { ?>
        <tr>
            <td><?= htmlspecialchars($fila['nombre']) ?></td>
            <td><?= htmlspecialchars($fila['apellido']) ?></td>
            <td><?= htmlspecialchars($fila['dni']) ?></td>
            <td><?= htmlspecialchars($fila['disciplina']) ?></td>
            <td><?= htmlspecialchars($fila['fecha_inscripcion']) ?></td>
            <td><?= $fila['anio_participacion'] ?></td>
            <td><?= htmlspecialchars($fila['estado']) ?></td>
        </tr>
        <?php } ?>
    </table>

</main>

</body>
</html>