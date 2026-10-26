<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_vehiculo = $_POST["id_vehiculo"] ?? "";
    $id_mecanico = $_POST["id_mecanico"] ?? "";
    $fecha_ingreso = $_POST["fecha_ingreso"] ?? "";
    $fecha_salida = $_POST["fecha_salida"] ?? "";
    $diagnostico = trim($_POST["diagnostico"] ?? "");
    $estado = $_POST["estado"] ?? "";

    if ($id_vehiculo === "" || $id_mecanico === "" || $fecha_ingreso === "") {
        $mensaje = "Debe seleccionar un vehículo, un mecánico e ingresar la fecha de ingreso.";
        $tipo_mensaje = "error";
    } elseif (!in_array($estado, ["en proceso", "finalizada", "cancelada"])) {
        $mensaje = "El estado debe ser: en proceso, finalizada o cancelada.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO reparacion (id_vehiculo, id_mecanico, fecha_ingreso, fecha_salida, diagnostico, estado)
                VALUES (:id_vehiculo, :id_mecanico, :fecha_ingreso, :fecha_salida, :diagnostico, :estado)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_vehiculo'   => (int)$id_vehiculo,
                ':id_mecanico'   => (int)$id_mecanico,
                ':fecha_ingreso' => $fecha_ingreso,
                ':fecha_salida'  => ($fecha_salida === "" ? null : $fecha_salida),
                ':diagnostico'   => $diagnostico,
                ':estado'        => $estado
            ]);

            $id_reparacion = $pdo->lastInsertId();

            header("Location: asociar.php?id=" . $id_reparacion);
            exit;

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar la reparación.";
            $tipo_mensaje = "error";
        }
    }
}

$vehiculos = $pdo->query("SELECT id_vehiculo, patente, marca, modelo FROM vehiculo ORDER BY patente")->fetchAll();
$mecanicos = $pdo->query("SELECT id_mecanico, nombre, apellido, especialidad FROM mecanico ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar reparación</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Reparaciones ]</a>
        <a href="alta.php">[ Nueva reparación ]</a>
        <a href="../vehiculo/listar.php">[ Vehículos ]</a>
        <a href="../mecanico/listar.php">[ Mecánicos ]</a>
        <a href="../servicio/listar.php">[ Servicios ]</a>
    </nav>
</header>

<main>

    <h2>Registrar reparación</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="id_vehiculo">Vehículo <span class="requerido">*</span></label>
        <select name="id_vehiculo" id="id_vehiculo" required>
            <option value="">Seleccione un vehículo</option>
            <?php foreach ($vehiculos as $vehiculo) { ?>
                <option value="<?= $vehiculo['id_vehiculo'] ?>">
                    <?= htmlspecialchars($vehiculo['patente'] . " — " . $vehiculo['marca'] . " " . $vehiculo['modelo']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_mecanico">Mecánico <span class="requerido">*</span></label>
        <select name="id_mecanico" id="id_mecanico" required>
            <option value="">Seleccione un mecánico</option>
            <?php foreach ($mecanicos as $mecanico) { ?>
                <option value="<?= $mecanico['id_mecanico'] ?>">
                    <?= htmlspecialchars($mecanico['apellido'] . ", " . $mecanico['nombre'] . " (" . (string)$mecanico['especialidad'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha_ingreso">Fecha de ingreso <span class="requerido">*</span></label>
        <input type="date" name="fecha_ingreso" id="fecha_ingreso" required
               value="<?= date('Y-m-d') ?>">

        <label for="fecha_salida">Fecha de salida</label>
        <input type="date" name="fecha_salida" id="fecha_salida">

        <label for="diagnostico">Diagnóstico</label>
        <textarea name="diagnostico" id="diagnostico" rows="3"><?= htmlspecialchars($_POST['diagnostico'] ?? '') ?></textarea>

        <label for="estado">Estado <span class="requerido">*</span></label>
        <select name="estado" id="estado" required>
            <option value="en proceso">En proceso</option>
            <option value="finalizada">Finalizada</option>
            <option value="cancelada">Cancelada</option>
        </select>

        <button type="submit">Registrar reparación y asociar servicios</button>

    </form>

    <p><a href="listar.php">Volver al listado de reparaciones</a></p>

</main>

</body>
</html>