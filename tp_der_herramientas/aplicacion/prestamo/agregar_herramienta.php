<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

$id_prestamo = $_GET["id"] ?? "";

// Si no hay id válido, mostrar selector
if ($id_prestamo === "" || !ctype_digit($id_prestamo)) {

    $sqlTodos = "SELECT pe.id_prestamo, pe.fecha_prestamo, pe.estado,
                        pe.fecha_devolucion_estimada,
                        pe.fecha_devolucion_real,
                        pr.nombre AS persona_nombre, pr.apellido AS persona_apellido
                 FROM prestamo pe
                 INNER JOIN persona pr ON pe.id_persona = pr.id_persona
                 ORDER BY pe.id_prestamo DESC";

    $prestamos = $pdo->query($sqlTodos)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar préstamo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>AGREGAR HERRAMIENTAS AL PRÉSTAMO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar préstamos ]</a>
        <a href="alta.php">[ Nuevo préstamo ]</a>
    </nav>
</header>

<main>

    <h2>Seleccione un préstamo</h2>

    <form method="get" action="agregar_herramienta.php">
        <label>Préstamo</label>
        <select name="id" required>
            <option value="">-- Seleccione un préstamo --</option>
            <?php foreach ($prestamos as $pe): ?>
                <option value="<?= $pe['id_prestamo'] ?>">
                    Préstamo #<?= $pe['id_prestamo'] ?> —
                    <?= htmlspecialchars($pe['persona_apellido'] . ", " . $pe['persona_nombre']) ?>
                    (<?= htmlspecialchars($pe['fecha_prestamo']) ?> — <?= htmlspecialchars($pe['estado']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Continuar</button>
    </form>

    <p><a href="listar.php">Volver al listado de préstamos</a></p>

</main>

</body>
</html>
<?php
    exit;
}

// Verificar que el préstamo exista
$sqlPre = "SELECT pe.id_prestamo, pe.fecha_prestamo, pe.estado,
                  pe.fecha_devolucion_estimada, pe.fecha_devolucion_real,
                  pr.nombre AS persona_nombre, pr.apellido AS persona_apellido,
                  pr.tipo_persona
           FROM prestamo pe
           INNER JOIN persona pr ON pe.id_persona = pr.id_persona
           WHERE pe.id_prestamo = :id";

$stmtPre = $pdo->prepare($sqlPre);
$stmtPre->execute([':id' => (int)$id_prestamo]);
$prestamo = $stmtPre->fetch();

if (!$prestamo) {
    header("Location: listar.php");
    exit;
}

// Procesar agregar herramienta
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_herramienta = $_POST["id_herramienta"] ?? "";

    if ($id_herramienta === "" || !ctype_digit($id_herramienta)) {
        $mensaje = "Debe seleccionar una herramienta.";
        $tipo_mensaje = "error";
    } else {

        // Verificar que la herramienta esté disponible
        $sqlEst = "SELECT estado FROM herramienta WHERE id_herramienta = :id";
        $stmtEst = $pdo->prepare($sqlEst);
        $stmtEst->execute([':id' => (int)$id_herramienta]);
        $her = $stmtEst->fetch();

        if (!$her) {
            $mensaje = "La herramienta seleccionada no existe.";
            $tipo_mensaje = "error";
        } elseif ($her["estado"] !== "disponible") {
            $mensaje = "La herramienta no está disponible (estado: " . $her["estado"] . ").";
            $tipo_mensaje = "error";
        } else {

            $sql = "INSERT INTO detalle_prestamo (id_prestamo, id_herramienta)
                    VALUES (:id_prestamo, :id_herramienta)";

            try {

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':id_prestamo'    => (int)$id_prestamo,
                    ':id_herramienta' => (int)$id_herramienta
                ]);

                // Marcar herramienta como prestada
                $upd = $pdo->prepare("UPDATE herramienta SET estado = 'prestada' WHERE id_herramienta = :id");
                $upd->execute([':id' => (int)$id_herramienta]);

                $mensaje = "Herramienta agregada al préstamo correctamente.";
                $tipo_mensaje = "exito";

            } catch (PDOException $e) {
                $mensaje = "No se pudo agregar la herramienta al préstamo.";
                $tipo_mensaje = "error";
            }
        }
    }
}

// Cargar herramientas disponibles
$herramientas = $pdo->query("SELECT id_herramienta, nombre, codigo_interno
                              FROM herramienta WHERE estado = 'disponible' ORDER BY nombre")->fetchAll();

// Cargar herramientas del préstamo
$sqlDet = "SELECT dp.id_detalle, h.nombre, h.codigo_interno, h.estado
           FROM detalle_prestamo dp
           INNER JOIN herramienta h ON dp.id_herramienta = h.id_herramienta
           WHERE dp.id_prestamo = :id
           ORDER BY dp.id_detalle";

$stmtDet = $pdo->prepare($sqlDet);
$stmtDet->execute([':id' => (int)$id_prestamo]);
$detalles = $stmtDet->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar herramientas al préstamo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>AGREGAR HERRAMIENTAS AL PRÉSTAMO #<?= $prestamo['id_prestamo'] ?></h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar préstamos ]</a>
        <a href="alta.php">[ Nuevo préstamo ]</a>
    </nav>
</header>

<main>

    <p>
        <strong>Persona:</strong> <?= htmlspecialchars($prestamo['persona_apellido'] . ", " . $prestamo['persona_nombre']) ?>
        (<?= htmlspecialchars($prestamo['tipo_persona']) ?>)
        &nbsp;|&nbsp;
        <strong>Fecha préstamo:</strong> <?= htmlspecialchars($prestamo['fecha_prestamo']) ?>
        &nbsp;|&nbsp;
        <strong>Estado:</strong> <?= htmlspecialchars($prestamo['estado']) ?>
    </p>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <h3>Agregar herramienta</h3>

    <form action="agregar_herramienta.php?id=<?= (int)$id_prestamo ?>" method="POST">
        <label>Herramienta <span class="requerido">*</span></label>
        <select name="id_herramienta" required>
            <option value="">-- Seleccione una herramienta disponible --</option>
            <?php foreach ($herramientas as $h): ?>
                <option value="<?= $h['id_herramienta'] ?>">
                    <?= htmlspecialchars($h['nombre'] . " (" . $h['codigo_interno'] . ")") ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Agregar al préstamo</button>
    </form>

    <h3>Herramientas del préstamo</h3>

    <?php if (count($detalles) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Estado actual</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detalles as $det): ?>
                    <tr>
                        <td><?= $det['id_detalle'] ?></td>
                        <td><?= htmlspecialchars($det['codigo_interno']) ?></td>
                        <td><?= htmlspecialchars($det['nombre']) ?></td>
                        <td><?= htmlspecialchars($det['estado']) ?></td>
                        <td>
                            <?php if ($prestamo['estado'] === 'activo' || $prestamo['estado'] === 'vencido'): ?>
                                <a class="btn-eliminar"
                                   href="eliminar_herramienta.php?id=<?= $det['id_detalle'] ?>&prestamo=<?= (int)$id_prestamo ?>"
                                   onclick="return confirm('¿Quitar esta herramienta del préstamo?');">Quitar</a>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">Todavía no se agregaron herramientas a este préstamo.</div>
    <?php endif; ?>

    <p>
        <a href="listar.php">Volver al listado de préstamos</a>
        &nbsp;|&nbsp;
        <a href="devolver.php">Registrar devolución</a>
    </p>

</main>

</body>
</html>