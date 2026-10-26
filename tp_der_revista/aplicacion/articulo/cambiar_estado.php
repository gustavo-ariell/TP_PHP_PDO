<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

$id_articulo = $_REQUEST["id"] ?? "";

// Si no hay id, mostrar selector
if ($id_articulo === "" || !ctype_digit($id_articulo)) {

    $sqlTodos = "SELECT ar.id_articulo, ar.titulo, e.nombre AS estado
                 FROM articulo ar
                 INNER JOIN estado_articulo e ON ar.id_estado = e.id_estado
                 ORDER BY ar.id_articulo DESC";
    $articulos = $pdo->query($sqlTodos)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar estado de artículo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>CAMBIAR ESTADO DE ARTÍCULO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar artículos ]</a>
    </nav>
</header>

<main>

    <h2>Seleccione un artículo</h2>

    <form method="get" action="cambiar_estado.php">
        <label>Artículo</label>
        <select name="id" required>
            <option value="">-- Seleccione un artículo --</option>
            <?php foreach ($articulos as $a): ?>
                <option value="<?= $a['id_articulo'] ?>">
                    #<?= $a['id_articulo'] ?> — <?= htmlspecialchars($a['titulo']) ?> (<?= htmlspecialchars($a['estado']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Continuar</button>
    </form>

    <p><a href="listar.php">Volver al listado de artículos</a></p>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>
<?php
    exit;
}

// Cargar artículo
$sqlArt = "SELECT ar.id_articulo, ar.titulo, e.nombre AS estado_actual, ar.id_estado
           FROM articulo ar
           INNER JOIN estado_articulo e ON ar.id_estado = e.id_estado
           WHERE ar.id_articulo = :id";

$stmtArt = $pdo->prepare($sqlArt);
$stmtArt->execute([':id' => (int)$id_articulo]);
$articulo = $stmtArt->fetch();

if (!$articulo) {
    header("Location: listar.php");
    exit;
}

// Procesar cambio
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_estado = $_POST["id_estado"] ?? "";

    if ($id_estado === "" || !ctype_digit($id_estado)) {
        $mensaje = "Debe seleccionar un estado.";
        $tipo_mensaje = "error";
    } else {

        try {

            $stmt = $pdo->prepare("UPDATE articulo SET id_estado = :id_estado WHERE id_articulo = :id");
            $stmt->execute([
                ':id_estado' => (int)$id_estado,
                ':id'        => (int)$id_articulo
            ]);

            $mensaje = "Estado modificado correctamente.";
            $tipo_mensaje = "exito";

            $stmtArt->execute([':id' => (int)$id_articulo]);
            $articulo = $stmtArt->fetch();

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el estado.";
            $tipo_mensaje = "error";
        }
    }
}

$estados = $pdo->query("SELECT id_estado, nombre FROM estado_articulo ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar estado</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>CAMBIAR ESTADO — ARTÍCULO #<?= $articulo['id_articulo'] ?></h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar artículos ]</a>
    </nav>
</header>

<main>

    <p>
        <strong>Título:</strong> <?= htmlspecialchars($articulo['titulo']) ?>
        &nbsp;|&nbsp;
        <strong>Estado actual:</strong> <?= htmlspecialchars($articulo['estado_actual']) ?>
    </p>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form action="cambiar_estado.php?id=<?= (int)$id_articulo ?>" method="POST">

        <label>Nuevo estado <span class="requerido">*</span></label>
        <select name="id_estado" required>
            <?php foreach ($estados as $e): ?>
                <option value="<?= $e['id_estado'] ?>"
                    <?= ($e['id_estado'] == $articulo['id_estado']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($e['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Guardar cambio</button>

    </form>

    <p><a href="listar.php">Volver al listado de artículos</a></p>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>