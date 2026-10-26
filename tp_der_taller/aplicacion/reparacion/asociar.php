<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

$id = (int)($_GET["id"] ?? $_POST["id_reparacion"] ?? 0);

// --- PROCESAR AGREGADO DE SERVICIO ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_servicio"]) && $id > 0) {

    $id_servicio = (int)($_POST["id_servicio"] ?? 0);
    $cantidad = (int)($_POST["cantidad"] ?? 1);
    $precio_aplicado = trim($_POST["precio_aplicado"] ?? "");

    if ($id_servicio === 0) {
        $mensaje = "Debe seleccionar un servicio.";
        $tipo_mensaje = "error";
    } elseif ($cantidad < 1) {
        $mensaje = "La cantidad debe ser al menos 1.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO reparacion_servicio (id_reparacion, id_servicio, cantidad, precio_aplicado)
                VALUES (:id_reparacion, :id_servicio, :cantidad, :precio_aplicado)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_reparacion'   => $id,
                ':id_servicio'     => $id_servicio,
                ':cantidad'        => $cantidad,
                ':precio_aplicado' => ($precio_aplicado === "" ? null : (float)$precio_aplicado)
            ]);

            $mensaje = "Servicio asociado a la reparación correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo asociar el servicio. Puede que ya esté incluido en esta reparación.";
            $tipo_mensaje = "error";
        }
    }
}

// --- OBTENER TODAS LAS REPARACIONES (para el selector si no hay id) ---
$reparaciones = $pdo->query(
    "SELECT r.id_reparacion, r.fecha_ingreso, v.patente, v.marca, v.modelo
     FROM reparacion r
     INNER JOIN vehiculo v ON r.id_vehiculo = v.id_vehiculo
     ORDER BY r.fecha_ingreso DESC"
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asociar servicios a reparación</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Reparaciones ]</a>
        <a href="alta.php">[ Nueva reparación ]</a>
        <a href="../servicio/listar.php">[ Servicios ]</a>
        <a href="../vehiculo/listar.php">[ Vehículos ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($id === 0) { ?>

        <!-- =================================================== -->
        <!-- SIN REPARACIÓN SELECCIONADA: mostrar selector        -->
        <!-- =================================================== -->

        <h2>Asociar servicios a una reparación</h2>

        <form action="asociar.php" method="get">

            <label for="id">Reparación <span class="requerido">*</span></label>
            <select name="id" id="id" required>
                <option value="">Seleccione una reparación</option>
                <?php foreach ($reparaciones as $rep) { ?>
                    <option value="<?= $rep['id_reparacion'] ?>">
                        <?= htmlspecialchars("Reparación #" . $rep['id_reparacion'] . " — " . $rep['patente'] . " (" . $rep['marca'] . " " . $rep['modelo'] . ") — " . $rep['fecha_ingreso']) ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit">Continuar</button>

        </form>

        <p><a href="listar.php">Volver al listado de reparaciones</a></p>

    <?php } else { ?>

        <!-- =================================================== -->
        <!-- CON REPARACIÓN SELECCIONADA: mostrar servicios       -->
        <!-- =================================================== -->

        <?php
        $sql_rep = "SELECT r.id_reparacion, r.fecha_ingreso, r.estado, r.diagnostico,
                           v.patente, v.marca, v.modelo,
                           m.nombre AS nombre_mecanico, m.apellido AS apellido_mecanico
                    FROM reparacion r
                    INNER JOIN vehiculo v ON r.id_vehiculo = v.id_vehiculo
                    INNER JOIN mecanico m ON r.id_mecanico = m.id_mecanico
                    WHERE r.id_reparacion = :id_reparacion";

        $stmt_rep = $pdo->prepare($sql_rep);
        $stmt_rep->execute([':id_reparacion' => $id]);
        $reparacion = $stmt_rep->fetch();

        if (!$reparacion) {

            echo '<p class="mensaje error">La reparación solicitada no existe.</p>';
            echo '<p><a href="asociar.php">Elegir otra reparación</a></p>';

        } else {

            $sql_servicios_rep = "SELECT s.nombre, s.precio, rs.cantidad, rs.precio_aplicado
                                  FROM reparacion_servicio rs
                                  INNER JOIN servicio s ON rs.id_servicio = s.id_servicio
                                  WHERE rs.id_reparacion = :id_reparacion
                                  ORDER BY s.nombre";

            $stmt_servicios_rep = $pdo->prepare($sql_servicios_rep);
            $stmt_servicios_rep->execute([':id_reparacion' => $id]);
            $servicios_rep = $stmt_servicios_rep->fetchAll();

            $todos_servicios = $pdo->query("SELECT id_servicio, nombre, precio FROM servicio ORDER BY nombre")->fetchAll();
        ?>

        <h2>Asociar servicios a la reparación #<?= $id ?></h2>

        <p>
            <strong>Vehículo:</strong> <?= htmlspecialchars($reparacion['patente'] . " — " . $reparacion['marca'] . " " . $reparacion['modelo']) ?><br>
            <strong>Mecánico:</strong> <?= htmlspecialchars($reparacion['apellido_mecanico'] . ", " . $reparacion['nombre_mecanico']) ?><br>
            <strong>Fecha de ingreso:</strong> <?= htmlspecialchars($reparacion['fecha_ingreso']) ?><br>
            <strong>Estado:</strong> <?= htmlspecialchars($reparacion['estado']) ?>
        </p>

        <h3>Servicios incluidos en esta reparación</h3>

        <table>
            <tr>
                <th>Servicio</th>
                <th>Cantidad</th>
                <th>Precio aplicado</th>
            </tr>
            <?php if (empty($servicios_rep)) { ?>
            <tr>
                <td colspan="3">Todavía no hay servicios asociados a esta reparación.</td>
            </tr>
            <?php } else { ?>
                <?php foreach ($servicios_rep as $srv) { ?>
                <tr>
                    <td><?= htmlspecialchars($srv['nombre']) ?></td>
                    <td><?= $srv['cantidad'] ?></td>
                    <td><?= $srv['precio_aplicado'] !== null ? "$" . number_format((float)$srv['precio_aplicado'], 2, ',', '.') : "—" ?></td>
                </tr>
                <?php } ?>
            <?php } ?>
        </table>

        <h3>Agregar servicio a la reparación</h3>

        <form action="asociar.php?id=<?= $id ?>" method="post">

            <input type="hidden" name="id_reparacion" value="<?= $id ?>">

            <label for="id_servicio">Servicio <span class="requerido">*</span></label>
            <select name="id_servicio" id="id_servicio" required>
                <option value="">Seleccione un servicio</option>
                <?php foreach ($todos_servicios as $srv) { ?>
                    <option value="<?= $srv['id_servicio'] ?>">
                        <?= htmlspecialchars($srv['nombre'] . ($srv['precio'] !== null ? " ($" . number_format((float)$srv['precio'], 2, ',', '.') . ")" : "")) ?>
                    </option>
                <?php } ?>
            </select>

            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" value="1" min="1">

            <label for="precio_aplicado">Precio aplicado</label>
            <input type="number" name="precio_aplicado" id="precio_aplicado" step="0.01" min="0">

            <button type="submit">Agregar servicio</button>

        </form>

        <p><a href="asociar.php">Elegir otra reparación</a> · <a href="listar.php">Volver al listado</a></p>

        <?php } ?>

    <?php } ?>

</main>

</body>
</html>