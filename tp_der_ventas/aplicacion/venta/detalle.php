<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_venta"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_producto"])) {

    $id_producto = (int)($_POST["id_producto"] ?? 0);
    $cantidad = (int)($_POST["cantidad"] ?? 0);

    if ($id_producto === 0 || $cantidad < 1) {

        $mensaje = "Debe seleccionar un producto e ingresar una cantidad mayor a 0.";
        $tipo_mensaje = "error";

    } else {

        $sql_precio = "SELECT precio FROM producto WHERE id_producto = :id_producto";
        $stmt_precio = $pdo->prepare($sql_precio);
        $stmt_precio->execute([':id_producto' => $id_producto]);
        $producto = $stmt_precio->fetch();

        if (!$producto) {
            $mensaje = "El producto seleccionado no existe.";
            $tipo_mensaje = "error";
        } else {

            $precio_unitario = (float)$producto['precio'];
            $subtotal = $precio_unitario * $cantidad;

            $sql_detalle = "INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio_unitario, subtotal)
                            VALUES (:id_venta, :id_producto, :cantidad, :precio_unitario, :subtotal)";

            try {

                $stmt_detalle = $pdo->prepare($sql_detalle);

                $stmt_detalle->execute([
                    ':id_venta'        => $id,
                    ':id_producto'     => $id_producto,
                    ':cantidad'        => $cantidad,
                    ':precio_unitario' => $precio_unitario,
                    ':subtotal'        => $subtotal
                ]);

                $sql_total = "UPDATE venta SET total = (
                                SELECT SUM(subtotal) FROM detalle_venta WHERE id_venta = :id_venta)
                              WHERE id_venta = :id_venta";

                $stmt_total = $pdo->prepare($sql_total);
                $stmt_total->execute([':id_venta' => $id]);

                $mensaje = "Producto agregado a la venta correctamente.";
                $tipo_mensaje = "exito";

            } catch (PDOException $e) {
                $mensaje = "No se pudo agregar el producto a la venta.";
                $tipo_mensaje = "error";
            }
        }
    }
}

$sql_venta = "SELECT
                  v.id_venta,
                  v.fecha,
                  v.total,
                  c.nombre AS nombre_cliente,
                  c.apellido AS apellido_cliente,
                  ve.nombre AS nombre_vendedor,
                  ve.apellido AS apellido_vendedor,
                  fp.nombre AS forma_pago
              FROM venta v
              INNER JOIN cliente c ON v.id_cliente = c.id_cliente
              INNER JOIN vendedor ve ON v.id_vendedor = ve.id_vendedor
              INNER JOIN forma_pago fp ON v.id_forma_pago = fp.id_forma_pago
              WHERE v.id_venta = :id_venta";

$stmt_venta = $pdo->prepare($sql_venta);
$stmt_venta->execute([':id_venta' => $id]);
$venta = $stmt_venta->fetch();

if (!$venta) {
    die("La venta solicitada no existe.");
}

$sql_detalle = "SELECT
                    dv.id_detalle,
                    dv.cantidad,
                    dv.precio_unitario,
                    dv.subtotal,
                    p.nombre AS producto
                FROM detalle_venta dv
                INNER JOIN producto p ON dv.id_producto = p.id_producto
                WHERE dv.id_venta = :id_venta";

$stmt_detalle = $pdo->prepare($sql_detalle);
$stmt_detalle->execute([':id_venta' => $id]);
$detalles = $stmt_detalle->fetchAll();

$productos = $pdo->query("SELECT id_producto, nombre, precio FROM producto ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de venta</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE VENTAS DE LIBRERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Ventas ]</a>
        <a href="alta.php">[ Nueva venta ]</a>
    </nav>
</header>

<main>

    <h2>Detalle de la venta N° <?= $venta['id_venta'] ?></h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <table>
        <tr>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Forma de pago</th>
            <th>Total</th>
        </tr>
        <tr>
            <td><?= htmlspecialchars($venta['fecha']) ?></td>
            <td><?= htmlspecialchars($venta['apellido_cliente'] . ", " . $venta['nombre_cliente']) ?></td>
            <td><?= htmlspecialchars($venta['apellido_vendedor'] . ", " . $venta['nombre_vendedor']) ?></td>
            <td><?= htmlspecialchars($venta['forma_pago']) ?></td>
            <td><strong>$<?= number_format((float)$venta['total'], 2, ',', '.') ?></strong></td>
        </tr>
    </table>

    <h3>Productos agregados</h3>

    <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio unitario</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($detalles as $detalle) { ?>
        <tr>
            <td><?= htmlspecialchars($detalle['producto']) ?></td>
            <td><?= $detalle['cantidad'] ?></td>
            <td>$<?= number_format((float)$detalle['precio_unitario'], 2, ',', '.') ?></td>
            <td>$<?= number_format((float)$detalle['subtotal'], 2, ',', '.') ?></td>
        </tr>
        <?php } ?>
    </table>

    <h3>Agregar producto a la venta</h3>

    <form action="detalle.php?id=<?= $id ?>" method="post">

        <input type="hidden" name="id_venta" value="<?= $id ?>">

        <label for="id_producto">Producto <span class="requerido">*</span></label>
        <select name="id_producto" id="id_producto" required>
            <option value="">Seleccione un producto</option>
            <?php foreach ($productos as $producto) { ?>
                <option value="<?= $producto['id_producto'] ?>">
                    <?= htmlspecialchars($producto['nombre'] . " — $" . number_format((float)$producto['precio'], 2, ',', '.')) ?>
                </option>
            <?php } ?>
        </select>

        <label for="cantidad">Cantidad <span class="requerido">*</span></label>
        <input type="number" name="cantidad" id="cantidad" min="1" required value="1">

        <button type="submit">Agregar producto</button>

    </form>

    <p><a href="listar.php">Volver al listado de ventas</a></p>

</main>

</body>
</html>