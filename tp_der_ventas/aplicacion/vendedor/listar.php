<?php
require_once "../conexion.php";

$sql = "SELECT id_vendedor, nombre, apellido, dni, telefono
        FROM vendedor ORDER BY apellido, nombre";

$stmt = $pdo->query($sql);
$vendedores = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de vendedores</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE VENTAS DE LIBRERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Vendedores ]</a>
        <a href="alta.php">[ Nuevo vendedor ]</a>
        <a href="../venta/listar.php">[ Ventas ]</a>
    </nav>
</header>

<main>

    <h2>Listado de vendedores</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($vendedores as $vendedor) { ?>
        <tr>
            <td><?= $vendedor['id_vendedor'] ?></td>
            <td><?= htmlspecialchars($vendedor['nombre']) ?></td>
            <td><?= htmlspecialchars($vendedor['apellido']) ?></td>
            <td><?= htmlspecialchars($vendedor['dni']) ?></td>
            <td><?= htmlspecialchars((string)$vendedor['telefono']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $vendedor['id_vendedor'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $vendedor['id_vendedor'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo vendedor</a></p>

</main>

</body>
</html>