<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_libro = (int)($_POST["id_libro"] ?? 0);
    $titulo = trim($_POST["titulo"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $anio = trim($_POST["anio"] ?? "");
    $archivo_digital = trim($_POST["archivo_digital"] ?? "");
    $idioma = trim($_POST["idioma"] ?? "");
    $id_categoria = $_POST["id_categoria"] ?? "";

    if ($titulo === "") {
        $mensaje = "Debe ingresar el título del libro.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE libro_digital SET
                    titulo = :titulo,
                    descripcion = :descripcion,
                    anio = :anio,
                    archivo_digital = :archivo_digital,
                    idioma = :idioma,
                    id_categoria = :id_categoria
                WHERE id_libro = :id_libro";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':titulo'          => $titulo,
                ':descripcion'     => $descripcion,
                ':anio'            => ($anio === "" ? null : (int)$anio),
                ':archivo_digital' => $archivo_digital,
                ':idioma'          => $idioma,
                ':id_categoria'    => ($id_categoria === "" ? null : (int)$id_categoria),
                ':id_libro'        => $id_libro
            ]);

            $mensaje = "Libro modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el libro.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_libro"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_libro, titulo, descripcion, anio, archivo_digital, idioma, id_categoria
        FROM libro_digital WHERE id_libro = :id_libro";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_libro' => $id]);
$libro = $stmt->fetch();

if (!$libro) {
    die("El libro solicitado no existe.");
}

$categorias = $pdo->query("SELECT id_categoria, nombre FROM categoria ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar libro</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Libros ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del libro</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_libro" value="<?= $libro['id_libro'] ?>">

        <label for="titulo">Título <span class="requerido">*</span></label>
        <input type="text" name="titulo" id="titulo" required
               value="<?= htmlspecialchars($libro['titulo']) ?>">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3"><?= htmlspecialchars((string)$libro['descripcion']) ?></textarea>

        <label for="anio">Año de publicación</label>
        <input type="number" name="anio" id="anio" min="1000" max="2100"
               value="<?= $libro['anio'] !== null ? $libro['anio'] : '' ?>">

        <label for="archivo_digital">Archivo digital</label>
        <input type="text" name="archivo_digital" id="archivo_digital"
               value="<?= htmlspecialchars((string)$libro['archivo_digital']) ?>">

        <label for="idioma">Idioma</label>
        <input type="text" name="idioma" id="idioma"
               value="<?= htmlspecialchars((string)$libro['idioma']) ?>">

        <label for="id_categoria">Categoría</label>
        <select name="id_categoria" id="id_categoria">
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categorias as $categoria) { ?>
                <option value="<?= $categoria['id_categoria'] ?>"
                    <?= $categoria['id_categoria'] == $libro['id_categoria'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($categoria['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>