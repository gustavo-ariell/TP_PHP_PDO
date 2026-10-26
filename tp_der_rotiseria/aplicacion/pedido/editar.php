<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_pedido = (int)($_POST["id_pedido"] ?? 0);
    $id_cliente = $_POST["id_cliente"] ?? "";
    $fecha = $_POST["fecha"] ?? "";
    $hora = $_POST["hora"] ?? "";
    $estado = $_POST["estado"] ?? "";
    $id_forma_entrega = $_POST["id_forma_entrega"] ?? "";
    $direccion_entrega = trim($_POST["direccion_entrega"] ?? "");
    $id_repartidor = $_POST["id_repartidor"] ?? "";

    if ($id_cliente === "" || $fecha === "" || $hora === "" || $id_forma_entrega === "") {
        $mensaje = "Debe completar todos los campos obligatorios.";
        $tipo_mensaje = "error";
    } elseif (!in_array($estado, ["pendiente", "en preparacion", "en camino", "entregado", "cancelado"])) {
        $mensaje = "El estado no es válido.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE pedido SET
                    id_cliente = :id_cliente,
                    fecha = :fecha,
                    hora = :hora,
                    estado = :estado,
                    id_forma_entrega = :id_forma_entrega,
                    direccion_entrega = :direccion_entrega,
                    id_repartidor = :id_repartidor
                WHERE id_pedido = :id_pedido";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_cliente'        => (int)$id_cliente,
                ':fecha'             => $fecha,
                ':hora'              => $hora,
                ':estado'            => $estado,
                ':id_forma_entrega'  => (int)$id_forma_entrega,
                ':direccion_entrega' => $direccion_entrega,
                ':id_repartidor'     => ($id_repartidor === "" ? null : (int)$id_repartidor),
                ':id_pedido'         => $id_pedido
            ]);

            $mensaje = "Pedido modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el pedido.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_pedido"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_pedido, id_cliente, fecha, hora, estado, id_forma_entrega, direccion_entrega, id_repartidor
        FROM pedido WHERE id_pedido = :id_pedido";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_pedido' => $id]);
$ped = $stmt->fetch();

if (!$ped) {
    die("El pedido solicitado no existe.");
}

$clientes = $pdo->query("SELECT id_cliente, nombre, apellido, dni FROM cliente ORDER BY apellido")->fetchAll();
$formas = $pdo->query("SELECT id_forma_entrega, nombre FROM forma_entrega ORDER BY nombre")->fetchAll();
$repartidores = $pdo->query("SELECT id_repartidor, nombre, apellido FROM repartidor ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar pedido</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PEDIDOS — ROTISERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Pedidos ]</a>
    </nav>
</header>

<main>

    <h2>Modificar pedido #<?= $ped['id_pedido'] ?></h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_pedido" value="<?= $ped['id_pedido'] ?>">

        <label for="id_cliente">Cliente <span class="requerido">*</span></label>
        <select name="id_cliente" id="id_cliente" required>
            <?php foreach ($clientes as $cliente) { ?>
                <option value="<?= $cliente['id_cliente'] ?>"
                    <?= $cliente['id_cliente'] == $ped['id_cliente'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($cliente['apellido'] . ", " . $cliente['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha">Fecha <span class="requerido">*</span></label>
        <input type="date" name="fecha" id="fecha" required
               value="<?= htmlspecialchars($ped['fecha']) ?>">

        <label for="hora">Hora <span class="requerido">*</span></label>
        <input type="time" name="hora" id="hora" required
               value="<?= htmlspecialchars($ped['hora']) ?>">

        <label for="estado">Estado <span class="requerido">*</span></label>
        <select name="estado" id="estado" required>
            <option value="pendiente" <?= $ped['estado'] === 'pendiente' ? "selected" : "" ?>>Pendiente</option>
            <option value="en preparacion" <?= $ped['estado'] === 'en preparacion' ? "selected" : "" ?>>En preparación</option>
            <option value="en camino" <?= $ped['estado'] === 'en camino' ? "selected" : "" ?>>En camino</option>
            <option value="entregado" <?= $ped['estado'] === 'entregado' ? "selected" : "" ?>>Entregado</option>
            <option value="cancelado" <?= $ped['estado'] === 'cancelado' ? "selected" : "" ?>>Cancelado</option>
        </select>

        <label for="id_forma_entrega">Forma de entrega <span class="requerido">*</span></label>
        <select name="id_forma_entrega" id="id_forma_entrega" required>
            <?php foreach ($formas as $forma) { ?>
                <option value="<?= $forma['id_forma_entrega'] ?>"
                    <?= $forma['id_forma_entrega'] == $ped['id_forma_entrega'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($forma['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="direccion_entrega">Dirección de entrega</label>
        <input type="text" name="direccion_entrega" id="direccion_entrega"
               value="<?= htmlspecialchars((string)$ped['direccion_entrega']) ?>">

        <label for="id_repartidor">Repartidor</label>
        <select name="id_repartidor" id="id_repartidor">
            <option value="">Sin repartidor asignado</option>
            <?php foreach ($repartidores as $rep) { ?>
                <option value="<?= $rep['id_repartidor'] ?>"
                    <?= $rep['id_repartidor'] == $ped['id_repartidor'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($rep['apellido'] . ", " . $rep['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>