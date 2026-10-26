<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_cliente = $_POST["id_cliente"] ?? "";
    $fecha = $_POST["fecha"] ?? "";
    $hora = $_POST["hora"] ?? "";
    $estado = $_POST["estado"] ?? "";
    $id_forma_entrega = $_POST["id_forma_entrega"] ?? "";
    $direccion_entrega = trim($_POST["direccion_entrega"] ?? "");
    $id_repartidor = $_POST["id_repartidor"] ?? "";

    if ($id_cliente === "" || $fecha === "" || $hora === "" || $id_forma_entrega === "") {
        $mensaje = "Debe completar cliente, fecha, hora y forma de entrega.";
        $tipo_mensaje = "error";
    } elseif (!in_array($estado, ["pendiente", "en preparacion", "en camino", "entregado", "cancelado"])) {
        $mensaje = "El estado no es válido.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO pedido
                    (id_cliente, fecha, hora, estado, id_forma_entrega,
                     direccion_entrega, id_repartidor)
                VALUES
                    (:id_cliente, :fecha, :hora, :estado,
                     :id_forma_entrega, :direccion_entrega, :id_repartidor)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_cliente'        => (int)$id_cliente,
                ':fecha'             => $fecha,
                ':hora'              => $hora,
                ':estado'            => $estado,
                ':id_forma_entrega'  => (int)$id_forma_entrega,
                ':direccion_entrega' => $direccion_entrega,
                ':id_repartidor'     => ($id_repartidor === "" ? null : (int)$id_repartidor)
            ]);

            $id_pedido = $pdo->lastInsertId();

            header("Location: agregar.php?id=" . $id_pedido);
            exit;

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el pedido.";
            $tipo_mensaje = "error";
        }
    }
}

$clientes     = $pdo->query("SELECT id_cliente, nombre, apellido, dni FROM cliente ORDER BY apellido")->fetchAll();
$formas       = $pdo->query("SELECT id_forma_entrega, nombre FROM forma_entrega ORDER BY nombre")->fetchAll();
$repartidores = $pdo->query("SELECT id_repartidor, nombre, apellido FROM repartidor ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar pedido</title>
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

    <h2>Registrar pedido</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="id_cliente">Cliente <span class="requerido">*</span></label>
        <select name="id_cliente" id="id_cliente" required>
            <option value="">Seleccione un cliente</option>
            <?php foreach ($clientes as $cliente) { ?>
                <option value="<?= $cliente['id_cliente'] ?>">
                    <?= htmlspecialchars($cliente['apellido'] . ", " . $cliente['nombre'] . " (DNI: " . $cliente['dni'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha">Fecha <span class="requerido">*</span></label>
        <input type="date" name="fecha" id="fecha" required
               value="<?= date('Y-m-d') ?>">

        <label for="hora">Hora <span class="requerido">*</span></label>
        <input type="time" name="hora" id="hora" required
               value="<?= date('H:i') ?>">

        <label for="estado">Estado <span class="requerido">*</span></label>
        <select name="estado" id="estado" required>
            <option value="pendiente">Pendiente</option>
            <option value="en preparacion">En preparación</option>
            <option value="en camino">En camino</option>
            <option value="entregado">Entregado</option>
            <option value="cancelado">Cancelado</option>
        </select>

        <label for="id_forma_entrega">Forma de entrega <span class="requerido">*</span></label>
        <select name="id_forma_entrega" id="id_forma_entrega" required>
            <option value="">Seleccione una forma</option>
            <?php foreach ($formas as $forma) { ?>
                <option value="<?= $forma['id_forma_entrega'] ?>">
                    <?= htmlspecialchars($forma['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="direccion_entrega">Dirección de entrega</label>
        <input type="text" name="direccion_entrega" id="direccion_entrega"
               value="<?= htmlspecialchars($_POST['direccion_entrega'] ?? '') ?>">

        <label for="id_repartidor">Repartidor</label>
        <select name="id_repartidor" id="id_repartidor">
            <option value="">Sin repartidor asignado</option>
            <?php foreach ($repartidores as $rep) { ?>
                <option value="<?= $rep['id_repartidor'] ?>">
                    <?= htmlspecialchars($rep['apellido'] . ", " . $rep['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Registrar pedido y agregar productos</button>

    </form>

    <p><a href="listar.php">Volver al listado de pedidos</a></p>

</main>

</body>
</html>
