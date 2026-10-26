<?php
require_once "../conexion.php";

$sql = "SELECT id_repartidor, nombre, apellido, telefono
        FROM repartidor ORDER BY apellido, nombre";

$stmt = $pdo->query($sql);
$repartidores = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de repartidores</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PEDIDOS — ROTISERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Repartidores ]</a>
        <a href="alta.php">[ Nuevo repartidor ]</a>
        <a href="../pedido/listar.php">[ Pedidos ]</a>
        <a href="../cliente/listar.php">[ Clientes ]</a>
    </nav>
</header>

<main>

    <h2>Listado de repartidores</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($repartidores as $repartidor) { ?>
        <tr>
            <td><?= $repartidor['id_repartidor'] ?></td>
            <td><?= htmlspecialchars($repartidor['nombre']) ?></td>
            <td><?= htmlspecialchars($repartidor['apellido']) ?></td>
            <td><?= htmlspecialchars((string)$repartidor['telefono']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $repartidor['id_repartidor'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $repartidor['id_repartidor'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo repartidor</a></p>

</main>

</body>
</html>