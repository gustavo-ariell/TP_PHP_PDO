<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

// Obtener id del pedido desde GET (si viene)
$id_pedido = $_GET["id"] ?? "";

// Si no viene un pedido válido, mostrar selector de pedido
if ($id_pedido === "" || !ctype_digit($id_pedido)) {

    // Cargar pedidos disponibles
    $sqlTodos = "SELECT pe.id_pedido, pe.fecha, pe.hora, pe.estado,
                        cl.nombre AS cliente_nombre, cl.apellido AS cliente_apellido
                 FROM pedido pe
                 INNER JOIN cliente cl ON pe.id_cliente = cl.id_cliente
                 ORDER BY pe.id_pedido DESC";

    $pedidos = $pdo->query($sqlTodos)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar pedido</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PEDIDOS — ROTISERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Pedidos ]</a>
        <a href="alta.php">[ Nuevo pedido ]</a>
        <a href="../cliente/listar.php">[ Clientes ]</a>
        <a href="../producto/listar.php">[ Productos ]</a>
    </nav>
</header>

<main>

    <h2>Seleccione un pedido para agregar productos</h2>

    <form method="get" action="agregar.php">
        <label for="id">Pedido</label>
        <select name="id" id="id" required>
            <option value="">Seleccione un pedido</option>
            <?php foreach ($pedidos as $pe) { ?>
                <option value="<?= $pe['id_pedido'] ?>">
                    Pedido #<?= $pe['id_pedido'] ?> —
                    <?= htmlspecialchars($pe['cliente_apellido'] . ", " . $pe['cliente_nombre']) ?>
                    (<?= htmlspecialchars($pe['fecha'] . " " . $pe['hora']) ?> —
                    <?= htmlspecialchars($pe['estado']) ?>)
                </option>
            <?php } ?>
        </select>
        <button type="submit">Continuar</button>
    </form>

    <p><a href="listar.php">Volver al listado de pedidos</a></p>

</main>

</body>
</html>
<?php
    exit;
}

// Verificar que el pedido exista
$sqlPedido = "SELECT pe.id_pedido, pe.fecha, pe.hora, pe.estado,
                     cl.nombre AS cliente_nombre, cl.apellido AS cliente_apellido
              FROM pedido pe
              INNER JOIN cliente cl ON pe.id_cliente = cl.id_cliente
              WHERE pe.id_pedido = :id_pedido";

$stmtPedido = $pdo->prepare($sqlPedido);
$stmtPedido->execute([':id_pedido' => (int)$id_pedido]);
$pedido = $stmtPedido->fetch();

if (!$pedido) {
    die("El pedido solicitado no existe. <a href='listar.php'>Volver al listado</a>");
}

// Procesar agregar producto al pedido
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_producto = $_POST["id_producto"] ?? "";
    $cantidad    = trim($_POST["cantidad"] ?? "");

    if ($id_producto === "" || !ctype_digit($id_producto)) {
        $mensaje = "Debe seleccionar un producto.";
        $tipo_mensaje = "error";
    } elseif ($cantidad === "" || !ctype_digit($cantidad) || (int)$cantidad < 1) {
        $mensaje = "La cantidad debe ser un número entero mayor que cero.";
        $tipo_mensaje = "error";
    } else {

        // Obtener precio actual del producto
        $sqlPrecio = "SELECT precio FROM producto WHERE id_producto = :id_producto";
        $stmtPrecio = $pdo->prepare($sqlPrecio);
        $stmtPrecio->execute([':id_producto' => (int)$id_producto]);
        $producto = $stmtPrecio->fetch();

        if (!$producto) {
            $mensaje = "El producto seleccionado no existe.";
            $tipo_mensaje = "error";
        } else {

            $precioUnitario = (float)$producto["precio"];
            $subtotal = $precioUnitario * (int)$cantidad;

            $sql = "INSERT INTO detalle_pedido
                        (id_pedido, id_producto, cantidad, precio_unitario, subtotal)
                    VALUES
                        (:id_pedido, :id_producto, :cantidad, :precio_unitario, :subtotal)";

            try {

                $stmt = $pdo->prepare($sql);

                $stmt->execute([
                    ':id_pedido'       => (int)$id_pedido,
                    ':id_producto'     => (int)$id_producto,
                    ':cantidad'        => (int)$cantidad,
                    ':precio_unitario' => $precioUnitario,
                    ':subtotal'        => $subtotal
                ]);

                $mensaje = "Producto agregado al pedido correctamente.";
                $tipo_mensaje = "exito";

            } catch (PDOException $e) {
                $mensaje = "No se pudo agregar el producto al pedido.";
                $tipo_mensaje = "error";
            }
        }
    }
}

// Listar productos disponibles
$productos = $pdo->query("SELECT id_producto, nombre, precio FROM producto ORDER BY nombre")->fetchAll();

// Listar productos ya agregados a este pedido
$sqlDetalle = "SELECT dp.id_detalle,
                      dp.cantidad,
                      dp.precio_unitario,
                      dp.subtotal,
                      pr.nombre AS producto_nombre
               FROM detalle_pedido dp
               INNER JOIN producto pr ON dp.id_producto = pr.id_producto
               WHERE dp.id_pedido = :id_pedido
               ORDER BY dp.id_detalle";

$stmtDetalle = $pdo->prepare($sqlDetalle);
$stmtDetalle->execute([':id_pedido' => (int)$id_pedido]);
$detalles = $stmtDetalle->fetchAll();

// Calcular total del pedido
$total = 0;
foreach ($detalles as $d) {
    $total += (float)$d["subtotal"];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar productos al pedido</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PEDIDOS — ROTISERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Pedidos ]</a>
        <a href="alta.php">[ Nuevo pedido ]</a>
        <a href="../cliente/listar.php">[ Clientes ]</a>
        <a href="../producto/listar.php">[ Productos ]</a>
    </nav>
</header>

<main>

    <h2>Agregar productos al pedido #<?= $pedido['id_pedido'] ?></h2>

    <p>
        <strong>Cliente:</strong>
        <?= htmlspecialchars($pedido['cliente_apellido'] . ", " . $pedido['cliente_nombre']) ?>
        &nbsp;|&nbsp;
        <strong>Fecha:</strong> <?= htmlspecialchars($pedido['fecha']) ?>
        &nbsp;|&nbsp;
        <strong>Hora:</strong> <?= htmlspecialchars($pedido['hora']) ?>
        &nbsp;|&nbsp;
        <strong>Estado:</strong> <?= htmlspecialchars($pedido['estado']) ?>
    </p>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <h3>Agregar producto</h3>

    <form action="agregar.php?id=<?= (int)$id_pedido ?>" method="post">

        <label for="id_producto">Producto <span class="requerido">*</span></label>
        <select name="id_producto" id="id_producto" required>
            <option value="">Seleccione un producto</option>
            <?php foreach ($productos as $prod) { ?>
                <option value="<?= $prod['id_producto'] ?>">
                    <?= htmlspecialchars($prod['nombre'] . " — $" . number_format((float)$prod['precio'], 2, ",", ".")) ?>
                </option>
            <?php } ?>
        </select>

        <label for="cantidad">Cantidad <span class="requerido">*</span></label>
        <input type="number" name="cantidad" id="cantidad" min="1" required>

        <button type="submit">Agregar al pedido</button>

    </form>

    <h3>Productos del pedido</h3>

    <?php if (count($detalles) > 0) { ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detalles as $det) { ?>
                    <tr>
                        <td><?= $det['id_detalle'] ?></td>
                        <td><?= htmlspecialchars($det['producto_nombre']) ?></td>
                        <td><?= $det['cantidad'] ?></td>
                        <td>$ <?= number_format((float)$det['precio_unitario'], 2, ",", ".") ?></td>
                        <td>$ <?= number_format((float)$det['subtotal'], 2, ",", ".") ?></td>
                        <td>
                            <a class="btn-eliminar"
                               href="eliminar_detalle.php?id=<?= $det['id_detalle'] ?>&pedido=<?= (int)$id_pedido ?>"
                               onclick="return confirm('¿Eliminar este producto del pedido?');">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"><strong>Total del pedido</strong></td>
                    <td colspan="2"><strong>$ <?= number_format($total, 2, ",", ".") ?></strong></td>
                </tr>
            </tfoot>
        </table>
    <?php } else { ?>
        <div class="mensaje error">Todavía no se agregaron productos a este pedido.</div>
    <?php } ?>

    <p>
        <a href="listar.php">Volver al listado de pedidos</a>
        &nbsp;|&nbsp;
        <a href="alta.php">Registrar nuevo pedido</a>
    </p>

</main>

</body>
</html>
