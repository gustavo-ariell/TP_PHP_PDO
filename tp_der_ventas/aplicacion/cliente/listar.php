<?php
require_once "../conexion.php";

$sql = "SELECT id_cliente, nombre, apellido, dni, telefono, email
        FROM cliente ORDER BY apellido, nombre";

$stmt = $pdo->query($sql);
$clientes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de clientes</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE VENTAS DE LIBRERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Clientes ]</a>
        <a href="alta.php">[ Nuevo cliente ]</a>
        <a href="../producto/listar.php">[ Productos ]</a>
        <a href="../venta/listar.php">[ Ventas ]</a>
    </nav>
</header>

<main>

    <h2>Listado de clientes</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($clientes as $cliente) { ?>
        <tr>
            <td><?= $cliente['id_cliente'] ?></td>
            <td><?= htmlspecialchars($cliente['nombre']) ?></td>
            <td><?= htmlspecialchars($cliente['apellido']) ?></td>
            <td><?= htmlspecialchars($cliente['dni']) ?></td>
            <td><?= htmlspecialchars((string)$cliente['telefono']) ?></td>
            <td><?= htmlspecialchars((string)$cliente['email']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $cliente['id_cliente'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $cliente['id_cliente'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo cliente</a></p>

</main>

</body>
</html>