<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titulo          = trim($_POST["titulo"] ?? "");
    $resumen         = trim($_POST["resumen"] ?? "");
    $palabras_clave  = trim($_POST["palabras_clave"] ?? "");
    $fecha_envio     = $_POST["fecha_envio"] ?? "";
    $archivo         = trim($_POST["archivo_principal"] ?? "");
    $id_seccion      = $_POST["id_seccion"] ?? "";
    $id_estado       = $_POST["id_estado"] ?? "";

    if ($titulo === "" || $fecha_envio === "") {
        $mensaje = "Debe ingresar el título y la fecha de envío.";
        $tipo_mensaje = "error";
    } elseif ($id_seccion === "" || !ctype_digit($id_seccion)) {
        $mensaje = "Debe seleccionar una sección.";
        $tipo_mensaje = "error";
    } elseif ($id_estado === "" || !ctype_digit($id_estado)) {
        $mensaje = "Debe seleccionar un estado.";
        $tipo_mensaje = "error";
    } else {

        try {

            $stmt = $pdo->prepare("INSERT INTO articulo
                    (titulo, resumen, palabras_clave, fecha_envio, archivo_principal, id_seccion, id_estado)
                   VALUES
                    (:titulo, :resumen, :palabras_clave, :fecha_envio, :archivo, :id_seccion, :id_estado)");

            $stmt->execute([
                ':titulo'         => $titulo,
                ':resumen'        => $resumen,
                ':palabras_clave' => $palabras_clave,
                ':fecha_envio'    => $fecha_envio,
                ':archivo'        => $archivo,
                ':id_seccion'     => (int)$id_seccion,
                ':id_estado'      => (int)$id_estado
            ]);

            $mensaje = "Artículo registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el artículo.";
            $tipo_mensaje = "error";
        }
    }
}

$secciones = $pdo->query("SELECT id_seccion, nombre FROM seccion ORDER BY nombre")->fetchAll();
$estados   = $pdo->query("SELECT id_estado, nombre FROM estado_articulo ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar artículo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>REGISTRAR ARTÍCULO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar artículos ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <h2>Nuevo artículo</h2>

    <form action="alta.php" method="POST">

        <label>Título <span class="requerido">*</span></label>
        <input type="text" name="titulo" required
               value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>">

        <label>Resumen</label>
        <textarea name="resumen" rows="3"><?= htmlspecialchars($_POST['resumen'] ?? '') ?></textarea>

        <label>Palabras clave</label>
        <input type="text" name="palabras_clave"
               value="<?= htmlspecialchars($_POST['palabras_clave'] ?? '') ?>">

        <label>Fecha de envío <span class="requerido">*</span></label>
        <input type="date" name="fecha_envio" required
               value="<?= htmlspecialchars($_POST['fecha_envio'] ?? date('Y-m-d')) ?>">

        <label>Archivo principal</label>
        <input type="text" name="archivo_principal"
               value="<?= htmlspecialchars($_POST['archivo_principal'] ?? '') ?>">

        <label>Sección <span class="requerido">*</span></label>
        <select name="id_seccion" required>
            <option value="">-- Seleccione una sección --</option>
            <?php foreach ($secciones as $s): ?>
                <option value="<?= $s['id_seccion'] ?>"
                    <?= (isset($_POST['id_seccion']) && $_POST['id_seccion'] == $s['id_seccion']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($s['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Estado <span class="requerido">*</span></label>
        <select name="id_estado" required>
            <option value="">-- Seleccione un estado --</option>
            <?php foreach ($estados as $e): ?>
                <option value="<?= $e['id_estado'] ?>"
                    <?= (isset($_POST['id_estado']) && $_POST['id_estado'] == $e['id_estado']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($e['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Registrar</button>

    </form>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>