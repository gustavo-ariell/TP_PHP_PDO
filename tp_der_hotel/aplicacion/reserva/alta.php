<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_huesped = $_POST["id_huesped"] ?? "";
    $id_habitacion = $_POST["id_habitacion"] ?? "";
    $fecha_ingreso = $_POST["fecha_ingreso"] ?? "";
    $fecha_salida = $_POST["fecha_salida"] ?? "";
    $cantidad_personas = $_POST["cantidad_personas"] ?? "";
    $estado = $_POST["estado"] ?? "";

    if ($id_huesped === "" || $id_habitacion === "" ||
        $fecha_ingreso === "" || $fecha_salida === "" || $cantidad_personas === "") {

        $mensaje = "Debe seleccionar un huésped, una habitación, ingresar fechas y la cantidad de personas.";
        $tipo_mensaje = "error";

    } elseif ($fecha_salida < $fecha_ingreso) {

        $mensaje = "La fecha de salida no puede ser anterior a la fecha de ingreso.";
        $tipo_mensaje = "error";

    } elseif (!is_numeric($cantidad_personas) || (int)$cantidad_personas < 1) {

        $mensaje = "La cantidad de personas debe ser un número mayor o igual a 1.";
        $tipo_mensaje = "error";

    } elseif (!in_array($estado, ["pendiente", "confirmada", "activa", "finalizada", "cancelada"])) {

        $mensaje = "El estado debe ser pendiente, confirmada, activa, finalizada o cancelada.";
        $tipo_mensaje = "error";

    } else {

        $sql = "INSERT INTO reserva
                    (id_huesped, id_habitacion, fecha_ingreso, fecha_salida, cantidad_personas, estado)
                VALUES
                    (:id_huesped, :id_habitacion, :fecha_ingreso, :fecha_salida, :cantidad_personas, :estado)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_huesped'         => (int)$id_huesped,
                ':id_habitacion'      => (int)$id_habitacion,
                ':fecha_ingreso'      => $fecha_ingreso,
                ':fecha_salida'       => $fecha_salida,
                ':cantidad_personas'  => (int)$cantidad_personas,
                ':estado'             => $estado
            ]);

            $mensaje = "Reserva generada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo generar la reserva.";
            $tipo_mensaje = "error";
        }
    }
}

$huespedes = $pdo->query("SELECT id_huesped, nombre, apellido, dni FROM huesped ORDER BY apellido")->fetchAll();
$habitaciones = $pdo->query("SELECT id_habitacion, numero, capacidad, precio_noche FROM habitacion ORDER BY numero")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generar reserva</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Reservas ]</a>
        <a href="alta.php">[ Nueva reserva ]</a>
        <a href="../huesped/listar.php">[ Huéspedes ]</a>
        <a href="../habitacion/listar.php">[ Habitaciones ]</a>
    </nav>
</header>

<main>

    <h2>Generar reserva</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="id_huesped">Huésped <span class="requerido">*</span></label>
        <select name="id_huesped" id="id_huesped" required>
            <option value="">Seleccione un huésped</option>
            <?php foreach ($huespedes as $huesped) { ?>
                <option value="<?= $huesped['id_huesped'] ?>">
                    <?= htmlspecialchars($huesped['apellido'] . ", " . $huesped['nombre'] . " (DNI: " . $huesped['dni'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_habitacion">Habitación <span class="requerido">*</span></label>
        <select name="id_habitacion" id="id_habitacion" required>
            <option value="">Seleccione una habitación</option>
            <?php foreach ($habitaciones as $habitacion) { ?>
                <option value="<?= $habitacion['id_habitacion'] ?>">
                    <?= htmlspecialchars("Hab. " . $habitacion['numero'] . " — Cap: " . $habitacion['capacidad'] . " — $" . number_format((float)$habitacion['precio_noche'], 2, ',', '.') . "/noche") ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha_ingreso">Fecha de ingreso <span class="requerido">*</span></label>
        <input type="date" name="fecha_ingreso" id="fecha_ingreso" required
               value="<?= htmlspecialchars($_POST['fecha_ingreso'] ?? date('Y-m-d')) ?>">

        <label for="fecha_salida">Fecha de salida <span class="requerido">*</span></label>
        <input type="date" name="fecha_salida" id="fecha_salida" required
               value="<?= htmlspecialchars($_POST['fecha_salida'] ?? '') ?>">

        <label for="cantidad_personas">Cantidad de personas <span class="requerido">*</span></label>
        <input type="number" name="cantidad_personas" id="cantidad_personas" min="1" required
               value="<?= htmlspecialchars($_POST['cantidad_personas'] ?? '1') ?>">

        <label for="estado">Estado <span class="requerido">*</span></label>
        <select name="estado" id="estado" required>
            <option value="pendiente">Pendiente</option>
            <option value="confirmada">Confirmada</option>
            <option value="activa">Activa</option>
            <option value="finalizada">Finalizada</option>
            <option value="cancelada">Cancelada</option>
        </select>

        <button type="submit">Generar reserva</button>

    </form>

    <p><a href="listar.php">Volver al listado de reservas</a></p>

</main>

</body>
</html>