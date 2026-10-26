<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre         = trim($_POST["nombre"] ?? "");
    $descripcion    = trim($_POST["descripcion"] ?? "");
    $codigo_interno = trim($_POST["codigo_interno"] ?? "");
    $estado         = $_POST["estado"] ?? "disponible";
    $id_categoria   = $_POST["id_categoria"] ?? "";

    $estadosValidos = ["disponible", "prestada", "en reparacion"];

    if ($nombre === "" || $codigo_interno === "") {
        $mensaje = "Debe ingresar el nombre y el código interno.";
        $tipo_mensaje = "error";
    } elseif (!in_array($estado, $estadosValidos)) {
        $mensaje = "Debe seleccionar un estado válido.";
        $tipo_mensaje = "error";
    } elseif ($id_categoria === "" || !ctype_digit($id_categoria)) {
        $mensaje = "Debe seleccionar una categoría.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO herramienta (nombre, descripcion, codigo_interno, estado, id_categoria)
                VALUES (:nombre, :descripcion, :codigo_interno, :estado, :id_categoria)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'         => $nombre,
                ':descripcion'    => $descripcion,
                ':codigo_interno' => $codigo_interno,
                ':estado'         => $estado,
                ':id_categoria'   => (int)$id_categoria
            ]);

            $mensaje = "Herramienta registrada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar. Verifique que el código interno no esté repetido.";
            $tipo_mensaje = "error";
        }
    }
}

$categorias = $pdo->query("SELECT id_categoria, nombre FROM categoria ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar herramienta</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>REGISTRAR HERRAMIENTA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar herramientas ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <h2>Nueva herramienta</h2>

    <form action="alta.php" method="POST">

        <label>Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <label>Descripción</label>
        <textarea name="descripcion" rows="3"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>

        <label>Código interno <span class="requerido">*</span></label>
        <input type="text" name="codigo_interno" required
               value="<?= htmlspecialchars($_POST['codigo_interno'] ?? '') ?>">

        <label>Estado <span class="requerido">*</span></label>
        <select name="estado" required>
            <option value="disponible" <?= ($_POST['estado'] ?? 'disponible') === 'disponible' ? 'selected' : '' ?>>
                Disponible
            </option>
            <option value="prestada" <?= ($_POST['estado'] ?? '') === 'prestada' ? 'selected' : '' ?>>
                Prestada
            </option>
            <option value="en reparacion" <?= ($_POST['estado'] ?? '') === 'en reparacion' ? 'selected' : '' ?>>
                En reparación
            </option>
        </select>

        <label>Categoría <span class="requerido">*</span></label>
        <select name="id_categoria" required>
            <option value="">-- Seleccione una categoría --</option>
            <?php foreach ($categorias as $c): ?>
                <option value="<?= $c['id_categoria'] ?>"
                    <?= (isset($_POST['id_categoria']) && $_POST['id_categoria'] == $c['id_categoria']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Registrar</button>

    </form>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Préstamos de Herramientas</p>
</footer>

</body>
</html>