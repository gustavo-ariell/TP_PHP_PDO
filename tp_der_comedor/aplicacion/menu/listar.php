<?php
require_once "../conexion.php";

$sql = "SELECT id_menu, fecha, descripcion FROM menu ORDER BY fecha DESC";

$stmt = $pdo->query($sql);
$menus = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de menús</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE COMEDOR UNIVERSITARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Menús ]</a>
        <a href="alta.php">[ Nuevo menú ]</a>
        <a href="../plato/listar.php">[ Platos ]</a>
        <a href="../reserva/listar.php">[ Reservas ]</a>
    </nav>
</header>

<main>

    <h2>Listado de menús</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($menus as $menu) { ?>
        <tr>
            <td><?= $menu['id_menu'] ?></td>
            <td><?= htmlspecialchars($menu['fecha']) ?></td>
            <td><?= htmlspecialchars((string)$menu['descripcion']) ?></td>
            <td>
                <a class="btn-editar" href="asociar.php?id=<?= $menu['id_menu'] ?>">Platos</a>
                <a class="btn-editar" href="editar.php?id=<?= $menu['id_menu'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $menu['id_menu'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo menú</a></p>

</main>

</body>
</html>