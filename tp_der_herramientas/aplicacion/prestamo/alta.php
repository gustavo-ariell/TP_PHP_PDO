<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_persona                = $_POST["id_persona"] ?? "";
    $fecha_prestamo            = $_POST["fecha_prestamo"] ?? "";
    $fecha_devolucion_estimada = $_POST["fecha_devolucion_estimada"] ?? "";

    if ($id_persona === "" || !ctype_digit($id_persona)) {
        $mensaje = "Debe seleccionar una persona.";
        $tipo_mensaje = "error";
    } elseif ($fecha_prestamo === "") {
        $mensaje = "Debe ingresar la fecha del préstamo.";
        $tipo_mensaje = "error";
    } elseif ($fecha_devolucion_estimada !== "" && $fecha_devolucion_estimada < $fecha_prestamo) {
        $mensaje = "La fecha de devolución estimada no puede ser anterior a la fecha del préstamo.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO prestamo (id_persona, fecha_prestamo, fecha_devolucion_estimada, estado)
                VALUES (:id_persona, :fecha_prestamo, :fecha_devolucion_estimada, 'activo')";

        try {

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id_persona'                => (int)$id_persona,
                ':fecha_prestamo'            => $fecha_prestamo,
                ':fecha_devolucion_estimada' => $fecha_devolucion_estimada ?: null
            ]);

            $id_prestamo = $pdo->lastInsertId();

            header("Location: agregar_herramienta.php?id=" . $id_prestamo);
            exit;

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el préstamo.";
            $tipo_mensaje = "error";
        }
    }
}

$personas = $pdo->query("SELECT id_persona, nombre, apellido, dni, tipo_persona FROM persona ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generar préstamo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>GENERAR PRÉSTAMO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar préstamos ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <h2>Nuevo préstamo</h2>

    <form action="alta.php" method="POST">

        <label>Persona <span class="requerido">*</span></label>
        <select name="id_persona" required>
            <option value="">-- Seleccione una persona --</option>
            <?php foreach ($personas as $p): ?>
                <option value="<?= $p['id_persona'] ?>">
                    <?= htmlspecialchars($p['apellido'] . ", " . $p['nombre'] . " (DNI: " . $p['dni'] . " — " . $p['tipo_persona'] . ")") ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Fecha del préstamo <span class="requerido">*</span></label>
        <input type="date" name="fecha_prestamo" required value="<?= date('Y-m-d') ?>">

        <label>Fecha de devolución estimada</label>
        <input type="date" name="fecha_devolucion_estimada">

        <button type="submit">Generar préstamo y agregar herramientas</button>

    </form>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Préstamos de Herramientas</p>
</footer>

</body>
</html>