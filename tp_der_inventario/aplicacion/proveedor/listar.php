<?php
require_once "../conexion.php";

$sql = "SELECT id_proveedor, nombre, contacto, telefono, email, direccion
        FROM proveedor ORDER BY nombre";

$stmt = $pdo->query($sql);
$proveedores = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de proveedores</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE INVENTARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Proveedores ]</a>
        <a href="alta.php">[ Nuevo proveedor ]</a>
        <a href="../producto/listar.php">[ Productos ]</a>
        <a href="../categoria/listar.php">[ Categorías ]</a>
    </nav>
</header>

<main>

    <h2>Listado de proveedores</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Contacto</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Dirección</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($proveedores as $proveedor) { ?>
        <tr>
            <td><?= $proveedor['id_proveedor'] ?></td>
            <td><?= htmlspecialchars($proveedor['nombre']) ?></td>
            <td><?= htmlspecialchars((string)$proveedor['contacto']) ?></td>
            <td><?= htmlspecialchars((string)$proveedor['telefono']) ?></td>
            <td><?= htmlspecialchars((string)$proveedor['email']) ?></td>
            <td><?= htmlspecialchars((string)$proveedor['direccion']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $proveedor['id_proveedor'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $proveedor['id_proveedor'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo proveedor</a></p>

</main>

</body>
</html>