<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_venta = (int)($_POST["id_venta"] ?? 0);
    $fecha = $_POST["fecha"] ?? "";
    $id_cliente = $_POST["id_cliente"] ?? "";
    $id_vendedor = $_POST["id_vendedor"] ?? "";
    $id_forma_pago = $_POST["id_forma_pago"] ?? "";

    if ($fecha === "" || $id_cliente === "" || $id_vendedor === "" || $id_forma_pago === "") {
        $mensaje = "Debe completar todos los campos obligatorios.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE venta SET
                    fecha = :fecha,
                    id_cliente = :id_cliente,
                    id_vendedor = :id_vendedor,
                    id_forma_pago = :id_forma_pago
                WHERE id_venta = :id_venta";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':fecha'          => $fecha,
                ':id_cliente'     => (int)$id_cliente,
                ':id_vendedor'    => (int)$id_vendedor,
                ':id_forma_pago'  => (int)$id_forma_pago,
                ':id_venta'       => $id_venta
            ]);

            $mensaje = "Venta modificada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar la venta.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_venta"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_venta, fecha, id_cliente, id_vendedor, id_forma_pago
        FROM venta WHERE id_venta = :id_venta";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_venta' => $id]);
$venta = $stmt->fetch();

if (!$venta) {
    die("La venta solicitada no existe.");
}

$clientes = $pdo->query("SELECT id_cliente, nombre, apellido, dni FROM cliente ORDER BY apellido")->fetchAll();
$vendedores = $pdo->query("SELECT id_vendedor, nombre, apellido FROM vendedor ORDER BY apellido")->fetchAll();
$formas_pago = $pdo->query("SELECT id_forma_pago, nombre FROM forma_pago ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar venta</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE VENTAS DE LIBRERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Ventas ]</a>
    </nav>
</header>

<main>

    <h2>Modificar venta N° <?= $venta['id_venta'] ?></h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_venta" value="<?= $venta['id_venta'] ?>">

        <label for="fecha">Fecha <span class="requerido">*</span></label>
        <input type="date" name="fecha" id="fecha" required
               value="<?= htmlspecialchars($venta['fecha']) ?>">

        <label for="id_cliente">Cliente <span class="requerido">*</span></label>
        <select name="id_cliente" id="id_cliente" required>
            <?php foreach ($clientes as $cliente) { ?>
                <option value="<?= $cliente['id_cliente'] ?>"
                    <?= $cliente['id_cliente'] == $venta['id_cliente'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($cliente['apellido'] . ", " . $cliente['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_vendedor">Vendedor <span class="requerido">*</span></label>
        <select name="id_vendedor" id="id_vendedor" required>
            <?php foreach ($vendedores as $vendedor) { ?>
                <option value="<?= $vendedor['id_vendedor'] ?>"
                    <?= $vendedor['id_vendedor'] == $venta['id_vendedor'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($vendedor['apellido'] . ", " . $vendedor['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_forma_pago">Forma de pago <span class="requerido">*</span></label>
        <select name="id_forma_pago" id="id_forma_pago" required>
            <?php foreach ($formas_pago as $forma) { ?>
                <option value="<?= $forma['id_forma_pago'] ?>"
                    <?= $forma['id_forma_pago'] == $venta['id_forma_pago'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($forma['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>