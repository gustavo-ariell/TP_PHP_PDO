<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_reparacion = (int)($_POST["id_reparacion"] ?? 0);
    $id_vehiculo = $_POST["id_vehiculo"] ?? "";
    $id_mecanico = $_POST["id_mecanico"] ?? "";
    $fecha_ingreso = $_POST["fecha_ingreso"] ?? "";
    $fecha_salida = $_POST["fecha_salida"] ?? "";
    $diagnostico = trim($_POST["diagnostico"] ?? "");
    $estado = $_POST["estado"] ?? "";

    if ($id_vehiculo === "" || $id_mecanico === "" || $fecha_ingreso === "") {
        $mensaje = "Debe completar todos los campos obligatorios.";
        $tipo_mensaje = "error";
    } elseif (!in_array($estado, ["en proceso", "finalizada", "cancelada"])) {
        $mensaje = "El estado debe ser: en proceso, finalizada o cancelada.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE reparacion SET
                    id_vehiculo = :id_vehiculo,
                    id_mecanico = :id_mecanico,
                    fecha_ingreso = :fecha_ingreso,
                    fecha_salida = :fecha_salida,
                    diagnostico = :diagnostico,
                    estado = :estado
                WHERE id_reparacion = :id_reparacion";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_vehiculo'   => (int)$id_vehiculo,
                ':id_mecanico'   => (int)$id_mecanico,
                ':fecha_ingreso' => $fecha_ingreso,
                ':fecha_salida'  => ($fecha_salida === "" ? null : $fecha_salida),
                ':diagnostico'   => $diagnostico,
                ':estado'        => $estado,
                ':id_reparacion' => $id_reparacion
            ]);

            $mensaje = "Reparación modificada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar la reparación.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_reparacion"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_reparacion, id_vehiculo, id_mecanico, fecha_ingreso, fecha_salida, diagnostico, estado
        FROM reparacion WHERE id_reparacion = :id_reparacion";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_reparacion' => $id]);
$rep = $stmt->fetch();

if (!$rep) {
    die("La reparación solicitada no existe.");
}

$vehiculos = $pdo->query("SELECT id_vehiculo, patente, marca, modelo FROM vehiculo ORDER BY patente")->fetchAll();
$mecanicos = $pdo->query("SELECT id_mecanico, nombre, apellido, especialidad FROM mecanico ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar reparación</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Reparaciones ]</a>
    </nav>
</header>

<main>

    <h2>Modificar reparación #<?= $rep['id_reparacion'] ?></h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_reparacion" value="<?= $rep['id_reparacion'] ?>">

        <label for="id_vehiculo">Vehículo <span class="requerido">*</span></label>
        <select name="id_vehiculo" id="id_vehiculo" required>
            <?php foreach ($vehiculos as $vehiculo) { ?>
                <option value="<?= $vehiculo['id_vehiculo'] ?>"
                    <?= $vehiculo['id_vehiculo'] == $rep['id_vehiculo'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($vehiculo['patente'] . " — " . $vehiculo['marca'] . " " . $vehiculo['modelo']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_mecanico">Mecánico <span class="requerido">*</span></label>
        <select name="id_mecanico" id="id_mecanico" required>
            <?php foreach ($mecanicos as $mecanico) { ?>
                <option value="<?= $mecanico['id_mecanico'] ?>"
                    <?= $mecanico['id_mecanico'] == $rep['id_mecanico'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($mecanico['apellido'] . ", " . $mecanico['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha_ingreso">Fecha de ingreso <span class="requerido">*</span></label>
        <input type="date" name="fecha_ingreso" id="fecha_ingreso" required
               value="<?= htmlspecialchars($rep['fecha_ingreso']) ?>">

        <label for="fecha_salida">Fecha de salida</label>
        <input type="date" name="fecha_salida" id="fecha_salida"
               value="<?= $rep['fecha_salida'] !== null ? htmlspecialchars($rep['fecha_salida']) : '' ?>">

        <label for="diagnostico">Diagnóstico</label>
        <textarea name="diagnostico" id="diagnostico" rows="3"><?= htmlspecialchars((string)$rep['diagnostico']) ?></textarea>

        <label for="estado">Estado <span class="requerido">*</span></label>
        <select name="estado" id="estado" required>
            <option value="en proceso" <?= $rep['estado'] === 'en proceso' ? "selected" : "" ?>>En proceso</option>
            <option value="finalizada" <?= $rep['estado'] === 'finalizada' ? "selected" : "" ?>>Finalizada</option>
            <option value="cancelada" <?= $rep['estado'] === 'cancelada' ? "selected" : "" ?>>Cancelada</option>
        </select>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>