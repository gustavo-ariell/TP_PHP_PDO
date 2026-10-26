<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fecha = $_POST["fecha"] ?? "";
    $id_cliente = $_POST["id_cliente"] ?? "";
    $id_vendedor = $_POST["id_vendedor"] ?? "";
    $id_forma_pago = $_POST["id_forma_pago"] ?? "";

    if ($fecha === "" || $id_cliente === "" || $id_vendedor === "" || $id_forma_pago === "") {

        $mensaje = "Debe seleccionar un cliente, un vendedor, una forma de pago e ingresar la fecha.";
        $tipo_mensaje = "error";

    } else {

        $sql = "INSERT INTO venta (fecha, id_cliente, id_vendedor, id_forma_pago, total)
                VALUES (:fecha, :id_cliente, :id_vendedor, :id_forma_pago, 0)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':fecha'          => $fecha,
                ':id_cliente'     => (int)$id_cliente,
                ':id_vendedor'    => (int)$id_vendedor,
                ':id_forma_pago'  => (int)$id_forma_pago
            ]);

            $id_venta = $pdo->lastInsertId();

            header("Location: detalle.php?id=" . $id_venta);
            exit;

        } catch (PDOException $e) {
            $mensaje = "No se pudo generar la venta.";
            $tipo_mensaje = "error";
        }
    }
}

$clientes = $pdo->query("SELECT id_cliente, nombre, apellido, dni FROM cliente ORDER BY apellido")->fetchAll();
$vendedores = $pdo->query("SELECT id_vendedor, nombre, apellido FROM vendedor ORDER BY apellido")->fetchAll();
$formas_pago = $pdo->query("SELECT id_forma_pago, nombre FROM forma_pago ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generar venta</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE VENTAS DE LIBRERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Ventas ]</a>
        <a href="alta.php">[ Nueva venta ]</a>
        <a href="../producto/listar.php">[ Productos ]</a>
        <a href="../cliente/listar.php">[ Clientes ]</a>
    </nav>
</header>

<main>

    <h2>Generar venta</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="fecha">Fecha <span class="requerido">*</span></label>
        <input type="date" name="fecha" id="fecha" required
               value="<?= date('Y-m-d') ?>">

        <label for="id_cliente">Cliente <span class="requerido">*</span></label>
        <select name="id_cliente" id="id_cliente" required>
            <option value="">Seleccione un cliente</option>
            <?php foreach ($clientes as $cliente) { ?>
                <option value="<?= $cliente['id_cliente'] ?>">
                    <?= htmlspecialchars($cliente['apellido'] . ", " . $cliente['nombre'] . " (DNI: " . $cliente['dni'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_vendedor">Vendedor <span class="requerido">*</span></label>
        <select name="id_vendedor" id="id_vendedor" required>
            <option value="">Seleccione un vendedor</option>
            <?php foreach ($vendedores as $vendedor) { ?>
                <option value="<?= $vendedor['id_vendedor'] ?>">
                    <?= htmlspecialchars($vendedor['apellido'] . ", " . $vendedor['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_forma_pago">Forma de pago <span class="requerido">*</span></label>
        <select name="id_forma_pago" id="id_forma_pago" required>
            <option value="">Seleccione una forma de pago</option>
            <?php foreach ($formas_pago as $forma) { ?>
                <option value="<?= $forma['id_forma_pago'] ?>">
                    <?= htmlspecialchars($forma['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Generar venta y agregar productos</button>

    </form>

    <p><a href="listar.php">Volver al listado de ventas</a></p>

</main>

</body>
</html>