<?php
require_once "../conexion.php";

$sql = "SELECT id_asistente, nombre, apellido, dni, email, institucion
        FROM asistente ORDER BY apellido, nombre";

$stmt = $pdo->query($sql);
$asistentes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de asistentes</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Asistentes ]</a>
        <a href="alta.php">[ Nuevo asistente ]</a>
        <a href="../evento/listar.php">[ Eventos ]</a>
        <a href="../inscripcion/listar.php">[ Inscripciones ]</a>
    </nav>
</header>

<main>

    <h2>Listado de asistentes</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Correo</th>
            <th>Institución</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($asistentes as $asistente) { ?>
        <tr>
            <td><?= $asistente['id_asistente'] ?></td>
            <td><?= htmlspecialchars($asistente['nombre']) ?></td>
            <td><?= htmlspecialchars($asistente['apellido']) ?></td>
            <td><?= htmlspecialchars($asistente['dni']) ?></td>
            <td><?= htmlspecialchars((string)$asistente['email']) ?></td>
            <td><?= htmlspecialchars((string)$asistente['institucion']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $asistente['id_asistente'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $asistente['id_asistente'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo asistente</a></p>

</main>

</body>
</html>