<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_producto = $_POST["id_producto"] ?? "";
    $tipo = $_POST["tipo"] ?? "";
    $fecha = $_POST["fecha"] ?? "";
    $cantidad = trim($_POST["cantidad"] ?? "");
    $motivo = trim($_POST["motivo"] ?? "");

    if ($id_producto === "" || $fecha === "" || $cantidad === "") {
        $mensaje = "Debe seleccionar un producto, ingresar la fecha y la cantidad.";
        $tipo_mensaje = "error";
    } elseif (!in_array($tipo, ["entrada", "salida"])) {
        $mensaje = "El tipo debe ser entrada o salida.";
        $tipo_mensaje = "error";
    } elseif (!is_numeric($cantidad) || (int)$cantidad <= 0) {
        $mensaje = "La cantidad debe ser un número mayor a 0.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO movimiento_stock (id_producto, tipo, fecha, cantidad, motivo)
                VALUES (:id_producto, :tipo, :fecha, :cantidad, :motivo)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_producto' => (int)$id_producto,
                ':tipo'        => $tipo,
                ':fecha'       => $fecha,
                ':cantidad'    => (int)$cantidad,
                ':motivo'      => $motivo
            ]);

            // Actualizar stock del producto
            if ($tipo === "entrada") {
                $sql_update = "UPDATE producto SET stock_actual = stock_actual + :cantidad
                               WHERE id_producto = :id_producto";
            } else {
                $sql_update = "UPDATE producto SET stock_actual = stock_actual - :cantidad
                               WHERE id_producto = :id_producto";
            }

            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->execute([
                ':cantidad'    => (int)$cantidad,
                ':id_producto' => (int)$id_producto
            ]);

            $mensaje = "Movimiento registrado correctamente. Stock actualizado.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el movimiento.";
            $tipo_mensaje = "error";
        }
    }
}

$productos = $pdo->query("SELECT id_producto, codigo, nombre, stock_actual FROM producto ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar movimiento de stock</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE INVENTARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Movimientos ]</a>
        <a href="alta.php">[ Nuevo movimiento ]</a>
        <a href="../producto/listar.php">[ Productos ]</a>
        <a href="../proveedor/listar.php">[ Proveedores ]</a>
    </nav>
</header>

<main>

    <h2>Registrar movimiento de stock</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="id_producto">Producto <span class="requerido">*</span></label>
        <select name="id_producto" id="id_producto" required>
            <option value="">Seleccione un producto</option>
            <?php foreach ($productos as $prod) { ?>
                <option value="<?= $prod['id_producto'] ?>">
                    <?= htmlspecialchars($prod['codigo'] . " — " . $prod['nombre'] . " (Stock: " . $prod['stock_actual'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <label for="tipo">Tipo <span class="requerido">*</span></label>
        <select name="tipo" id="tipo" required>
            <option value="entrada">Entrada</option>
            <option value="salida">Salida</option>
        </select>

        <label for="fecha">Fecha <span class="requerido">*</span></label>
        <input type="date" name="fecha" id="fecha" required
               value="<?= date('Y-m-d') ?>">

        <label for="cantidad">Cantidad <span class="requerido">*</span></label>
        <input type="number" name="cantidad" id="cantidad" min="1" required
               value="<?= htmlspecialchars($_POST['cantidad'] ?? '') ?>">

        <label for="motivo">Motivo</label>
        <input type="text" name="motivo" id="motivo"
               value="<?= htmlspecialchars($_POST['motivo'] ?? '') ?>">

        <button type="submit">Registrar movimiento</button>

    </form>

    <p><a href="listar.php">Volver al listado de movimientos</a></p>

</main>

</body>
</html>