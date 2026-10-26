<?php
require_once "../conexion.php";

$sql = "SELECT id_expositor, nombre, apellido, tema_exposicion, email
        FROM expositor ORDER BY apellido, nombre";

$stmt = $pdo->query($sql);
$expositores = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de expositores</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Expositores ]</a>
        <a href="alta.php">[ Nuevo expositor ]</a>
        <a href="../evento/listar.php">[ Eventos ]</a>
        <a href="../asistente/listar.php">[ Asistentes ]</a>
    </nav>
</header>

<main>

    <h2>Listado de expositores</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Tema de exposición</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($expositores as $expositor) { ?>
        <tr>
            <td><?= $expositor['id_expositor'] ?></td>
            <td><?= htmlspecialchars($expositor['nombre']) ?></td>
            <td><?= htmlspecialchars($expositor['apellido']) ?></td>
            <td><?= htmlspecialchars((string)$expositor['tema_exposicion']) ?></td>
            <td><?= htmlspecialchars((string)$expositor['email']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $expositor['id_expositor'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $expositor['id_expositor'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo expositor</a></p>

</main>

</body>
</html>