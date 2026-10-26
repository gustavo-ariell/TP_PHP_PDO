<?php
require_once "../conexion.php";

$sql = "SELECT id_plato, nombre, descripcion, tipo FROM plato ORDER BY nombre";

$stmt = $pdo->query($sql);
$platos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de platos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE COMEDOR UNIVERSITARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Platos ]</a>
        <a href="alta.php">[ Nuevo plato ]</a>
        <a href="../menu/listar.php">[ Menús ]</a>
        <a href="../reserva/listar.php">[ Reservas ]</a>
    </nav>
</header>

<main>

    <h2>Listado de platos</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Tipo</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($platos as $plato) { ?>
        <tr>
            <td><?= $plato['id_plato'] ?></td>
            <td><?= htmlspecialchars($plato['nombre']) ?></td>
            <td><?= htmlspecialchars((string)$plato['descripcion']) ?></td>
            <td><?= htmlspecialchars((string)$plato['tipo']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $plato['id_plato'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $plato['id_plato'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo plato</a></p>

</main>

</body>
</html>