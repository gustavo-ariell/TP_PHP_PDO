<?php
require_once "../conexion.php";

$sql = "SELECT id_tipo, nombre FROM tipo_evento ORDER BY nombre";

$stmt = $pdo->query($sql);
$tipos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de tipos de evento</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Tipos ]</a>
        <a href="alta.php">[ Nuevo tipo ]</a>
        <a href="../evento/listar.php">[ Eventos ]</a>
        <a href="../expositor/listar.php">[ Expositores ]</a>
    </nav>
</header>

<main>

    <h2>Listado de tipos de evento</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($tipos as $tipo) { ?>
        <tr>
            <td><?= $tipo['id_tipo'] ?></td>
            <td><?= htmlspecialchars($tipo['nombre']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $tipo['id_tipo'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $tipo['id_tipo'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo tipo</a></p>

</main>

</body>
</html>