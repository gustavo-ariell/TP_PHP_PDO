<?php
require_once "../conexion.php";

$sql = "SELECT
            m.fecha,
            m.descripcion,
            p.nombre AS plato,
            p.tipo
        FROM menu m
        INNER JOIN menu_plato mp ON m.id_menu = mp.id_menu
        INNER JOIN plato p ON mp.id_plato = p.id_plato
        ORDER BY m.fecha DESC, p.tipo, p.nombre";

$stmt = $pdo->query($sql);
$platos_menus = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Platos incluidos en cada menú</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE COMEDOR UNIVERSITARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="reservas_por_fecha.php">[ Por fecha ]</a>
        <a href="estudiantes_con_reservas.php">[ Estudiantes con reservas ]</a>
        <a href="platos_por_menu.php">[ Platos por menú ]</a>
        <a href="../menu/listar.php">[ Menús ]</a>
    </nav>
</header>

<main>

    <h2>Platos incluidos en cada menú</h2>

    <table>
        <tr>
            <th>Fecha menú</th>
            <th>Descripción</th>
            <th>Plato</th>
            <th>Tipo</th>
        </tr>
        <?php foreach ($platos_menus as $fila) { ?>
        <tr>
            <td><?= htmlspecialchars($fila['fecha']) ?></td>
            <td><?= htmlspecialchars((string)$fila['descripcion']) ?></td>
            <td><?= htmlspecialchars($fila['plato']) ?></td>
            <td><?= htmlspecialchars((string)$fila['tipo']) ?></td>
        </tr>
        <?php } ?>
    </table>

</main>

</body>
</html>