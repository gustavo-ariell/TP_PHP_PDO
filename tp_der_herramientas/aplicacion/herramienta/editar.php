<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$her = null;

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {
    $stmt = $pdo->prepare("SELECT * FROM herramienta WHERE id_herramienta = :id");
    $stmt->execute([':id' => (int)$_GET["id"]]);
    $her = $stmt->fetch();
    if (!$her) $mensaje = "La herramienta solicitada no existe.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id             = $_POST["id_herramienta"] ?? "";
    $nombre         = trim($_POST["nombre"] ?? "");
    $descripcion    = trim($_POST["descripcion"] ?? "");
    $codigo_interno = trim($_POST["codigo_interno"] ?? "");
    $estado         = $_POST["estado"] ?? "disponible";
    $id_categoria   = $_POST["id_categoria"] ?? "";

    $estadosValidos = ["disponible", "prestada", "en reparacion"];

    if (!ctype_digit($id)) {
        $mensaje = "Identificador inválido.";
        $tipo_mensaje = "error";
    } elseif ($nombre === "" || $codigo_interno === "") {
        $mensaje = "Debe ingresar el nombre y el código interno.";
        $tipo_mensaje = "error";
    } elseif (!in_array($estado, $estadosValidos)) {
        $mensaje = "Debe seleccionar un estado válido.";
        $tipo_mensaje = "error";
    } elseif ($id_categoria === "" || !ctype_digit($id_categoria)) {
        $mensaje = "Debe seleccionar una categoría.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE herramienta
                SET nombre = :nombre, descripcion = :descripcion,
                    codigo_interno = :codigo_interno, estado = :estado,
                    id_categoria = :id_categoria
                WHERE id_herramienta = :id";

        try {

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nombre'         => $nombre,
                ':descripcion'    => $descripcion,
                ':codigo_interno' => $codigo_interno,
                ':estado'         => $estado,
                ':id_categoria'   => (int)$id_categoria,
                ':id'             => (int)$id
            ]);

            $mensaje = "Herramienta modificada correctamente.";
            $tipo_mensaje = "exito";

            $stmt2 = $pdo->prepare("SELECT * FROM herramienta WHERE id_herramienta = :id");
            $stmt2->execute([':id' => (int)$id]);
            $her = $stmt2->fetch();

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar la herramienta.";
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
    <title>Editar herramienta</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>MODIFICAR HERRAMIENTA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar herramientas ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <?php if ($her): ?>
        <h2>Modificar datos de la herramienta</h2>
        <form action="editar.php" method="POST">
            <input type="hidden" name="id_herramienta" value="<?= $her['id_herramienta'] ?>">

            <label>Nombre <span class="requerido">*</span></label>
            <input type="text" name="nombre" required value="<?= htmlspecialchars($her['nombre']) ?>">

            <label>Descripción</label>
            <textarea name="descripcion" rows="3"><?= htmlspecialchars($her['descripcion'] ?? '') ?></textarea>

            <label>Código interno <span class="requerido">*</span></label>
            <input type="text" name="codigo_interno" required value="<?= htmlspecialchars($her['codigo_interno']) ?>">

            <label>Estado <span class="requerido">*</span></label>
            <select name="estado" required>
                <option value="disponible" <?= $her['estado'] === 'disponible' ? 'selected' : '' ?>>Disponible</option>
                <option value="prestada" <?= $her['estado'] === 'prestada' ? 'selected' : '' ?>>Prestada</option>
                <option value="en reparacion" <?= $her['estado'] === 'en reparacion' ? 'selected' : '' ?>>En reparación</option>
            </select>

            <label>Categoría <span class="requerido">*</span></label>
            <select name="id_categoria" required>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= $c['id_categoria'] ?>"
                        <?= ($c['id_categoria'] == $her['id_categoria']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Guardar cambios</button>
        </form>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Préstamos de Herramientas</p>
</footer>

</body>
</html>