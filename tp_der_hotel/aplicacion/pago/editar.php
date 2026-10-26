<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_pago = (int)($_POST["id_pago"] ?? 0);
    $id_reserva = $_POST["id_reserva"] ?? "";
    $fecha_pago = $_POST["fecha_pago"] ?? "";
    $monto = $_POST["monto"] ?? "";
    $metodo_pago = trim($_POST["metodo_pago"] ?? "");

    if ($id_reserva === "" || $fecha_pago === "" || $monto === "") {
        $mensaje = "Debe completar todos los campos obligatorios.";
        $tipo_mensaje = "error";
    } elseif (!is_numeric($monto) || (float)$monto <= 0) {
        $mensaje = "El monto debe ser un número mayor a 0.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE pago SET
                    id_reserva = :id_reserva,
                    fecha_pago = :fecha_pago,
                    monto = :monto,
                    metodo_pago = :metodo_pago
                WHERE id_pago = :id_pago";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_reserva'  => (int)$id_reserva,
                ':fecha_pago'  => $fecha_pago,
                ':monto'       => (float)$monto,
                ':metodo_pago' => $metodo_pago,
                ':id_pago'     => $id_pago
            ]);

            $mensaje = "Pago modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el pago.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_pago"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_pago, id_reserva, fecha_pago, monto, metodo_pago
        FROM pago WHERE id_pago = :id_pago";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_pago' => $id]);
$pago = $stmt->fetch();

if (!$pago) {
    die("El pago solicitado no existe.");
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
    <title>Modificar pago</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Pagos ]</a>
    </nav>
</header>

<main>

    <h2>Modificar pago</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_pago" value="<?= $pago['id_pago'] ?>">

        <label for="id_reserva">Reserva <span class="requerido">*</span></label>
        <select name="id_reserva" id="id_reserva" required>
            <?php foreach ($reservas as $reserva) { ?>
                <option value="<?= $reserva['id_reserva'] ?>"
                    <?= $reserva['id_reserva'] == $pago['id_reserva'] ? "selected" : "" ?>>
                    <?= htmlspecialchars("Res. " . $reserva['id_reserva'] . " — " . $reserva['apellido'] . ", " . $reserva['nombre'] . " — Hab. " . $reserva['numero']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha_pago">Fecha de pago <span class="requerido">*</span></label>
        <input type="date" name="fecha_pago" id="fecha_pago" required
               value="<?= htmlspecialchars($pago['fecha_pago']) ?>">

        <label for="monto">Monto <span class="requerido">*</span></label>
        <input type="number" name="monto" id="monto" step="0.01" min="0.01" required
               value="<?= $pago['monto'] ?>">

        <label for="metodo_pago">Método de pago</label>
        <input type="text" name="metodo_pago" id="metodo_pago"
               value="<?= htmlspecialchars((string)$pago['metodo_pago']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>