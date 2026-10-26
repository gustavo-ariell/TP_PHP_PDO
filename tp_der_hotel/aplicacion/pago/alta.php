<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_reserva = $_POST["id_reserva"] ?? "";
    $fecha_pago = $_POST["fecha_pago"] ?? "";
    $monto = $_POST["monto"] ?? "";
    $metodo_pago = trim($_POST["metodo_pago"] ?? "");

    if ($id_reserva === "" || $fecha_pago === "" || $monto === "") {

        $mensaje = "Debe seleccionar una reserva, ingresar la fecha y el monto.";
        $tipo_mensaje = "error";

    } elseif (!is_numeric($monto) || (float)$monto <= 0) {

        $mensaje = "El monto debe ser un número mayor a 0.";
        $tipo_mensaje = "error";

    } else {

        $sql = "INSERT INTO pago (id_reserva, fecha_pago, monto, metodo_pago)
                VALUES (:id_reserva, :fecha_pago, :monto, :metodo_pago)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_reserva'  => (int)$id_reserva,
                ':fecha_pago'  => $fecha_pago,
                ':monto'       => (float)$monto,
                ':metodo_pago' => $metodo_pago
            ]);

            $mensaje = "Pago registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el pago.";
            $tipo_mensaje = "error";
        }
    }
}

$reservas = $pdo->query("SELECT
                            r.id_reserva,
                            r.fecha_ingreso,
                            h.nombre,
                            h.apellido,
                            hab.numero
                        FROM reserva r
                        INNER JOIN huesped h ON r.id_huesped = h.id_huesped
                        INNER JOIN habitacion hab ON r.id_habitacion = hab.id_habitacion
                        ORDER BY r.fecha_ingreso DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar pago</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Pagos ]</a>
        <a href="alta.php">[ Nuevo pago ]</a>
        <a href="../reserva/listar.php">[ Reservas ]</a>
    </nav>
</header>

<main>

    <h2>Registrar pago</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="id_reserva">Reserva <span class="requerido">*</span></label>
        <select name="id_reserva" id="id_reserva" required>
            <option value="">Seleccione una reserva</option>
            <?php foreach ($reservas as $reserva) { ?>
                <option value="<?= $reserva['id_reserva'] ?>">
                    <?= htmlspecialchars("Res. " . $reserva['id_reserva'] . " — " . $reserva['apellido'] . ", " . $reserva['nombre'] . " — Hab. " . $reserva['numero'] . " — " . $reserva['fecha_ingreso']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha_pago">Fecha de pago <span class="requerido">*</span></label>
        <input type="date" name="fecha_pago" id="fecha_pago" required
               value="<?= date('Y-m-d') ?>">

        <label for="monto">Monto <span class="requerido">*</span></label>
        <input type="number" name="monto" id="monto" step="0.01" min="0.01" required
               value="<?= htmlspecialchars($_POST['monto'] ?? '') ?>">

        <label for="metodo_pago">Método de pago</label>
        <input type="text" name="metodo_pago" id="metodo_pago"
               value="<?= htmlspecialchars($_POST['metodo_pago'] ?? '') ?>">

        <button type="submit">Registrar pago</button>

    </form>

    <p><a href="listar.php">Volver al listado de pagos</a></p>

</main>

</body>
</html>