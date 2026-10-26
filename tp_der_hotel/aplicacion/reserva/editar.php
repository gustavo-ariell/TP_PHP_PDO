<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_reserva = (int)($_POST["id_reserva"] ?? 0);
    $id_huesped = $_POST["id_huesped"] ?? "";
    $id_habitacion = $_POST["id_habitacion"] ?? "";
    $fecha_ingreso = $_POST["fecha_ingreso"] ?? "";
    $fecha_salida = $_POST["fecha_salida"] ?? "";
    $cantidad_personas = $_POST["cantidad_personas"] ?? "";
    $estado = $_POST["estado"] ?? "";

    if ($id_huesped === "" || $id_habitacion === "" ||
        $fecha_ingreso === "" || $fecha_salida === "" || $cantidad_personas === "") {

        $mensaje = "Debe completar todos los campos obligatorios.";
        $tipo_mensaje = "error";

    } elseif ($fecha_salida < $fecha_ingreso) {

        $mensaje = "La fecha de salida no puede ser anterior a la fecha de ingreso.";
        $tipo_mensaje = "error";

    } elseif (!in_array($estado, ["pendiente", "confirmada", "activa", "finalizada", "cancelada"])) {

        $mensaje = "El estado debe ser pendiente, confirmada, activa, finalizada o cancelada.";
        $tipo_mensaje = "error";

    } else {

        $sql = "UPDATE reserva SET
                    id_huesped = :id_huesped,
                    id_habitacion = :id_habitacion,
                    fecha_ingreso = :fecha_ingreso,
                    fecha_salida = :fecha_salida,
                    cantidad_personas = :cantidad_personas,
                    estado = :estado
                WHERE id_reserva = :id_reserva";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_huesped'         => (int)$id_huesped,
                ':id_habitacion'      => (int)$id_habitacion,
                ':fecha_ingreso'      => $fecha_ingreso,
                ':fecha_salida'       => $fecha_salida,
                ':cantidad_personas'  => (int)$cantidad_personas,
                ':estado'             => $estado,
                ':id_reserva'         => $id_reserva
            ]);

            $mensaje = "Reserva modificada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar la reserva.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_reserva"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_reserva, id_huesped, id_habitacion, fecha_ingreso, fecha_salida,
               cantidad_personas, estado
        FROM reserva WHERE id_reserva = :id_reserva";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_reserva' => $id]);
$reserva = $stmt->fetch();

if (!$reserva) {
    die("La reserva solicitada no existe.");
}

$huespedes = $pdo->query("SELECT id_huesped, nombre, apellido, dni FROM huesped ORDER BY apellido")->fetchAll();
$habitaciones = $pdo->query("SELECT id_habitacion, numero, capacidad, precio_noche FROM habitacion ORDER BY numero")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar reserva</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Reservas ]</a>
    </nav>
</header>

<main>

    <h2>Modificar estado de reserva</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_reserva" value="<?= $reserva['id_reserva'] ?>">

        <label for="id_huesped">Huésped <span class="requerido">*</span></label>
        <select name="id_huesped" id="id_huesped" required>
            <?php foreach ($huespedes as $huesped) { ?>
                <option value="<?= $huesped['id_huesped'] ?>"
                    <?= $huesped['id_huesped'] == $reserva['id_huesped'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($huesped['apellido'] . ", " . $huesped['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_habitacion">Habitación <span class="requerido">*</span></label>
        <select name="id_habitacion" id="id_habitacion" required>
            <?php foreach ($habitaciones as $habitacion) { ?>
                <option value="<?= $habitacion['id_habitacion'] ?>"
                    <?= $habitacion['id_habitacion'] == $reserva['id_habitacion'] ? "selected" : "" ?>>
                    <?= htmlspecialchars("Hab. " . $habitacion['numero']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha_ingreso">Fecha de ingreso <span class="requerido">*</span></label>
        <input type="date" name="fecha_ingreso" id="fecha_ingreso" required
               value="<?= htmlspecialchars($reserva['fecha_ingreso']) ?>">

        <label for="fecha_salida">Fecha de salida <span class="requerido">*</span></label>
        <input type="date" name="fecha_salida" id="fecha_salida" required
               value="<?= htmlspecialchars($reserva['fecha_salida']) ?>">

        <label for="cantidad_personas">Cantidad de personas <span class="requerido">*</span></label>
        <input type="number" name="cantidad_personas" id="cantidad_personas" min="1" required
               value="<?= $reserva['cantidad_personas'] ?>">

        <label for="estado">Estado <span class="requerido">*</span></label>
        <select name="estado" id="estado" required>
            <option value="pendiente" <?= $reserva['estado'] === 'pendiente' ? "selected" : "" ?>>Pendiente</option>
            <option value="confirmada" <?= $reserva['estado'] === 'confirmada' ? "selected" : "" ?>>Confirmada</option>
            <option value="activa" <?= $reserva['estado'] === 'activa' ? "selected" : "" ?>>Activa</option>
            <option value="finalizada" <?= $reserva['estado'] === 'finalizada' ? "selected" : "" ?>>Finalizada</option>
            <option value="cancelada" <?= $reserva['estado'] === 'cancelada' ? "selected" : "" ?>>Cancelada</option>
        </select>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>