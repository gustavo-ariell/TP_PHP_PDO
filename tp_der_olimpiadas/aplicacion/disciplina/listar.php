<?php
require_once "../conexion.php";

$sql = "SELECT id_disciplina, nombre, descripcion
        FROM disciplina
        ORDER BY nombre";

$stmt = $pdo->query($sql);
$disciplinas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de disciplinas</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE INSCRIPCIÓN A OLIMPIADAS ESCOLARES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Disciplinas ]</a>
        <a href="alta.php">[ Nueva disciplina ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
        <a href="../inscripcion/listar.php">[ Inscripciones ]</a>
    </nav>
</header>

<main>

    <h2>Listado de disciplinas</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($disciplinas as $disciplina) { ?>
        <tr>
            <td><?= $disciplina['id_disciplina'] ?></td>
            <td><?= htmlspecialchars($disciplina['nombre']) ?></td>
            <td><?= htmlspecialchars((string)$disciplina['descripcion']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $disciplina['id_disciplina'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $disciplina['id_disciplina'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar una nueva disciplina</a></p>

</main>

</body>
</html>