<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

$id_prestamo = $_REQUEST["id"] ?? "";

// Si no hay id, mostrar selector de préstamos activos/vencidos
if ($id_prestamo === "" || !ctype_digit($id_prestamo)) {

    $sqlActivos = "SELECT pe.id_prestamo, pe.fecha_prestamo,
                          pe.fecha_devolucion_estimada, pe.estado,
                          pr.nombre AS persona_nombre, pr.apellido AS persona_apellido
                   FROM prestamo pe
                   INNER JOIN persona pr ON pe.id_persona = pr.id_persona
                   WHERE pe.estado IN ('activo', 'vencido')
                   ORDER BY pe.id_prestamo DESC";

    $activos = $pdo->query($sqlActivos)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar devolución</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>REGISTRAR DEVOLUCIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar préstamos ]</a>
    </nav>
</header>

<main>

    <h2>Seleccione un préstamo para devolver</h2>

    <form method="get" action="devolver.php">
        <label>Préstamo</label>
        <select name="id" required>
            <option value="">-- Seleccione un préstamo --</option>
            <?php foreach ($activos as $pe): ?>
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

// Verificar préstamo
$sqlPre = "SELECT pe.id_prestamo, pe.fecha_prestamo, pe.fecha_devolucion_estimada,
                  pe.fecha_devolucion_real, pe.estado,
                  pr.nombre AS persona_nombre, pr.apellido AS persona_apellido
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

// Procesar devolución
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fecha_devolucion_real = $_POST["fecha_devolucion_real"] ?? "";

    if ($fecha_devolucion_real === "") {
        $mensaje = "Debe ingresar la fecha de devolución real.";
        $tipo_mensaje = "error";
    } else {

        try {

            // Actualizar préstamo
            $sql = "UPDATE prestamo
                    SET fecha_devolucion_real = :fecha_devolucion_real,
                        estado = 'devuelto'
                    WHERE id_prestamo = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':fecha_devolucion_real' => $fecha_devolucion_real,
                ':id'                    => (int)$id_prestamo
            ]);

            // Devolver todas las herramientas a disponible
            $upd = $pdo->prepare("UPDATE herramienta
                                  SET estado = 'disponible'
                                  WHERE id_herramienta IN (
                                      SELECT id_herramienta FROM detalle_prestamo
                                      WHERE id_prestamo = :id
                                  )");
            $upd->execute([':id' => (int)$id_prestamo]);

            $mensaje = "Devolución registrada correctamente.";
            $tipo_mensaje = "exito";

            // Recargar datos
            $stmtPre->execute([':id' => (int)$id_prestamo]);
            $prestamo = $stmtPre->fetch();

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar la devolución.";
            $tipo_mensaje = "error";
        }
    }
}

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
    <title>Registrar devolución</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>REGISTRAR DEVOLUCIÓN — PRÉSTAMO #<?= $prestamo['id_prestamo'] ?></h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar préstamos ]</a>
    </nav>
</header>

<main>

    <p>
        <strong>Persona:</strong> <?= htmlspecialchars($prestamo['persona_apellido'] . ", " . $prestamo['persona_nombre']) ?>
        &nbsp;|&nbsp;
        <strong>Fecha préstamo:</strong> <?= htmlspecialchars($prestamo['fecha_prestamo']) ?>
        &nbsp;|&nbsp;
        <strong>Dev. estimada:</strong> <?= htmlspecialchars($prestamo['fecha_devolucion_estimada'] ?? '—') ?>
        &nbsp;|&nbsp;
        <strong>Estado:</strong> <?= htmlspecialchars($prestamo['estado']) ?>
    </p>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <h3>Herramientas del préstamo</h3>

    <?php if (count($detalles) > 0): ?>
        <table>
            <thead>
                <tr><th>#</th><th>Código</th><th>Nombre</th><th>Estado</th></tr>
            </thead>
            <tbody>
                <?php foreach ($detalles as $det): ?>
                    <tr>
                        <td><?= $det['id_detalle'] ?></td>
                        <td><?= htmlspecialchars($det['codigo_interno']) ?></td>
                        <td><?= htmlspecialchars($det['nombre']) ?></td>
                        <td><?= htmlspecialchars($det['estado']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">Este préstamo no tiene herramientas asociadas.</div>
    <?php endif; ?>

    <?php if ($prestamo['estado'] !== 'devuelto'): ?>
        <h3>Registrar devolución</h3>
        <form action="devolver.php?id=<?= (int)$id_prestamo ?>" method="POST">
            <label>Fecha de devolución real <span class="requerido">*</span></label>
            <input type="date" name="fecha_devolucion_real" required value="<?= date('Y-m-d') ?>">
            <button type="submit">Confirmar devolución</button>
        </form>
    <?php else: ?>
        <div class="mensaje exito">Este préstamo ya fue devuelto el <?= htmlspecialchars($prestamo['fecha_devolucion_real']) ?>.</div>
    <?php endif; ?>

    <p><a href="listar.php">Volver al listado de préstamos</a></p>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Préstamos de Herramientas</p>
</footer>

</body>
</html>