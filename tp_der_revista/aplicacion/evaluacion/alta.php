<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_articulo   = $_POST["id_articulo"] ?? "";
    $id_evaluador  = $_POST["id_evaluador"] ?? "";
    $fecha         = $_POST["fecha"] ?? "";
    $dictamen      = $_POST["dictamen"] ?? "";
    $observaciones = trim($_POST["observaciones"] ?? "");

    if (!ctype_digit($id_articulo) || !ctype_digit($id_evaluador)) {
        $mensaje = "Debe seleccionar un artículo y un evaluador.";
        $tipo_mensaje = "error";
    } elseif ($fecha === "" || $dictamen === "") {
        $mensaje = "Debe ingresar la fecha y el dictamen.";
        $tipo_mensaje = "error";
    } else {

        try {

            $stmt = $pdo->prepare("INSERT INTO evaluacion (id_articulo, id_evaluador, fecha, dictamen, observaciones)
                                   VALUES (:id_articulo, :id_evaluador, :fecha, :dictamen, :observaciones)");
            $stmt->execute([
                ':id_articulo'   => (int)$id_articulo,
                ':id_evaluador'  => (int)$id_evaluador,
                ':fecha'         => $fecha,
                ':dictamen'      => $dictamen,
                ':observaciones' => $observaciones
            ]);

            $mensaje = "Evaluación registrada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar la evaluación.";
            $tipo_mensaje = "error";
        }
    }
}

$articulos   = $pdo->query("SELECT id_articulo, titulo FROM articulo ORDER BY titulo")->fetchAll();
$evaluadores = $pdo->query("SELECT id_evaluador, nombre, apellido, especialidad FROM evaluador ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar evaluación</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>REGISTRAR EVALUACIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar evaluaciones ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <h2>Nueva evaluación</h2>

    <form action="alta.php" method="POST">

        <label>Artículo <span class="requerido">*</span></label>
        <select name="id_articulo" required>
            <option value="">-- Seleccione un artículo --</option>
            <?php foreach ($articulos as $a): ?>
                <option value="<?= $a['id_articulo'] ?>"><?= htmlspecialchars($a['titulo']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Evaluador <span class="requerido">*</span></label>
        <select name="id_evaluador" required>
            <option value="">-- Seleccione un evaluador --</option>
            <?php foreach ($evaluadores as $e): ?>
                <option value="<?= $e['id_evaluador'] ?>">
                    <?= htmlspecialchars($e['apellido'] . ", " . $e['nombre'] . " (" . $e['especialidad'] . ")") ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Fecha <span class="requerido">*</span></label>
        <input type="date" name="fecha" required value="<?= date('Y-m-d') ?>">

        <label>Dictamen <span class="requerido">*</span></label>
        <select name="dictamen" required>
            <option value="">-- Seleccione --</option>
            <option value="aprobado">Aprobado</option>
            <option value="correcciones">Correcciones</option>
            <option value="rechazado">Rechazado</option>
        </select>

        <label>Observaciones</label>
        <textarea name="observaciones" rows="3"></textarea>

        <button type="submit">Registrar evaluación</button>

    </form>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>