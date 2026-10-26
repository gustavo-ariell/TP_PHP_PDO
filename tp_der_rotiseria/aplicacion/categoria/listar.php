<?php
require_once "../conexion.php";

$sql = "SELECT id_categoria, nombre FROM categoria ORDER BY nombre";

$stmt = $pdo->query($sql);
$categorias = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de categorías</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PEDIDOS — ROTISERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Categorías ]</a>
        <a href="alta.php">[ Nueva categoría ]</a>
        <a href="../producto/listar.php">[ Productos ]</a>
        <a href="../pedido/listar.php">[ Pedidos ]</a>
    </nav>
</header>

<main>

    <h2>Listado de categorías</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($categorias as $categoria) { ?>
        <tr>
            <td><?= $categoria['id_categoria'] ?></td>
            <td><?= htmlspecialchars($categoria['nombre']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $categoria['id_categoria'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $categoria['id_categoria'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar una nueva categoría</a></p>

</main>

</body>
</html>