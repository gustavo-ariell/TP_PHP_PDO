<?php
require_once "../conexion.php";

$proveedores = $pdo->query("SELECT id_proveedor, nombre FROM proveedor ORDER BY nombre")->fetchAll();

$id_proveedor = $_POST["id_proveedor"] ?? "";
$productos = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_proveedor !== "") {

    $sql = "SELECT
                p.codigo,
                p.nombre,
                p.precio,
                p.stock_actual,
                c.nombre AS categoria
            FROM producto_proveedor pp
            INNER JOIN producto p ON pp.id_producto = p.id_producto
            LEFT JOIN categoria c ON p.id_categoria = c.id_categoria
            WHERE pp.id_proveedor = :id_proveedor
            ORDER BY p.nombre";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_proveedor' => (int)$id_proveedor]);
    $productos = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos por proveedor</title>
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
        <a href="../proveedor/listar.php">[ Proveedores ]</a>
    </nav>
</header>

<main>

    <h2>Productos por proveedor</h2>

    <form action="productos_por_proveedor.php" method="post">

        <label for="id_proveedor">Proveedor <span class="requerido">*</span></label>
        <select name="id_proveedor" id="id_proveedor" required>
            <option value="">Seleccione un proveedor</option>
            <?php foreach ($proveedores as $prov) { ?>
                <option value="<?= $prov['id_proveedor'] ?>"
                    <?= $prov['id_proveedor'] == $id_proveedor ? "selected" : "" ?>>
                    <?= htmlspecialchars($prov['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>

        <table>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock actual</th>
                <th>Categoría</th>
            </tr>
            <?php foreach ($productos as $fila) { ?>
            <tr>
                <td><?= htmlspecialchars($fila['codigo']) ?></td>
                <td><?= htmlspecialchars($fila['nombre']) ?></td>
                <td>$<?= number_format((float)$fila['precio'], 2, ',', '.') ?></td>
                <td><?= $fila['stock_actual'] ?></td>
                <td><?= htmlspecialchars((string)$fila['categoria']) ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>