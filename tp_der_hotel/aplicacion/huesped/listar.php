<?php
require_once "../conexion.php";

$sql = "SELECT id_huesped, nombre, apellido, dni, telefono, email
        FROM huesped ORDER BY apellido, nombre";

$stmt = $pdo->query($sql);
$huespedes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de huéspedes</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Huéspedes ]</a>
        <a href="alta.php">[ Nuevo huésped ]</a>
        <a href="../habitacion/listar.php">[ Habitaciones ]</a>
        <a href="../reserva/listar.php">[ Reservas ]</a>
    </nav>
</header>

<main>

    <h2>Listado de huéspedes</h2>

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
        <?php foreach ($huespedes as $huesped) { ?>
        <tr>
            <td><?= $huesped['id_huesped'] ?></td>
            <td><?= htmlspecialchars($huesped['nombre']) ?></td>
            <td><?= htmlspecialchars($huesped['apellido']) ?></td>
            <td><?= htmlspecialchars($huesped['dni']) ?></td>
            <td><?= htmlspecialchars((string)$huesped['telefono']) ?></td>
            <td><?= htmlspecialchars((string)$huesped['email']) ?></td>
            <td>
                <a class="btn-editar" href="editar.php?id=<?= $huesped['id_huesped'] ?>">Modificar</a>
                <a class="btn-eliminar" href="eliminar.php?id=<?= $huesped['id_huesped'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="alta.php">Registrar un nuevo huésped</a></p>

</main>

</body>
</html>