<?php
require_once "../conexion.php";

$productos = $pdo->query("SELECT id_producto, codigo, nombre FROM producto ORDER BY nombre")->fetchAll();

$id_producto = $_POST["id_producto"] ?? "";
$movimientos = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_producto !== "") {

    $sql = "SELECT
                m.id_movimiento,
                m.tipo,
                m.fecha,
                m.cantidad,
                m.motivo,
                p.codigo,
                p.nombre AS producto
            FROM movimiento_stock m
            INNER JOIN producto p ON m.id_producto = p.id_producto
            WHERE m.id_producto = :id_producto
            ORDER BY m.fecha DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_producto' => (int)$id_producto]);
    $movimientos = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Movimientos por producto</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE INVENTARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="productos_por_categoria.php">[ Productos por categoría ]</a>
        <a href="movimientos_por_producto.php">[ Movimientos por producto ]</a>
        <a href="productos_por_proveedor.php">[ Productos por proveedor ]</a>
        <a href="../movimiento/listar.php">[ Movimientos ]</a>
    </nav>
</header>

<main>

    <h2>Movimientos de stock por producto</h2>

    <form action="movimientos_por_producto.php" method="post">

        <label for="id_producto">Producto <span class="requerido">*</span></label>
        <select name="id_producto" id="id_producto" required>
            <option value="">Seleccione un producto</option>
            <?php foreach ($productos as $prod) { ?>
                <option value="<?= $prod['id_producto'] ?>"
                    <?= $prod['id_producto'] == $id_producto ? "selected" : "" ?>>
                    <?= htmlspecialchars($prod['codigo'] . " — " . $prod['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Cantidad</th>
                <th>Motivo</th>
            </tr>
            <?php foreach ($movimientos as $fila) { ?>
            <tr>
                <td><?= $fila['id_movimiento'] ?></td>
                <td><?= htmlspecialchars($fila['tipo']) ?></td>
                <td><?= htmlspecialchars($fila['fecha']) ?></td>
                <td><?= $fila['cantidad'] ?></td>
                <td><?= htmlspecialchars((string)$fila['motivo']) ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>