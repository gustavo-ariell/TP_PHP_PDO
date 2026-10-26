<?php
require_once "../conexion.php";

$categorias = $pdo->query("SELECT id_categoria, nombre FROM categoria ORDER BY nombre")->fetchAll();

$id_categoria = $_POST["id_categoria"] ?? "";
$productos = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_categoria !== "") {

    $sql = "SELECT
                p.codigo,
                p.nombre,
                p.descripcion,
                p.precio,
                p.stock_actual,
                p.stock_minimo,
                c.nombre AS categoria
            FROM producto p
            LEFT JOIN categoria c ON p.id_categoria = c.id_categoria
            WHERE p.id_categoria = :id_categoria
            ORDER BY p.nombre";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_categoria' => (int)$id_categoria]);
    $productos = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos por categoría</title>
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
        <a href="../producto/listar.php">[ Productos ]</a>
    </nav>
</header>

<main>

    <h2>Productos por categoría</h2>

    <form action="productos_por_categoria.php" method="post">

        <label for="id_categoria">Categoría <span class="requerido">*</span></label>
        <select name="id_categoria" id="id_categoria" required>
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categorias as $categoria) { ?>
                <option value="<?= $categoria['id_categoria'] ?>"
                    <?= $categoria['id_categoria'] == $id_categoria ? "selected" : "" ?>>
                    <?= htmlspecialchars($categoria['nombre']) ?>
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
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock actual</th>
                <th>Stock mínimo</th>
            </tr>
            <?php foreach ($productos as $fila) { ?>
            <tr>
                <td><?= htmlspecialchars($fila['codigo']) ?></td>
                <td><?= htmlspecialchars($fila['nombre']) ?></td>
                <td><?= htmlspecialchars((string)$fila['descripcion']) ?></td>
                <td>$<?= number_format((float)$fila['precio'], 2, ',', '.') ?></td>
                <td><?= $fila['stock_actual'] ?></td>
                <td><?= $fila['stock_minimo'] ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>