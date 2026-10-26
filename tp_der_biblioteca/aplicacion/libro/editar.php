<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_libro = (int)($_POST["id_libro"] ?? 0);
    $titulo = trim($_POST["titulo"] ?? "");
    $isbn = trim($_POST["isbn"] ?? "");
    $anio = $_POST["anio_publicacion"] ?? "";
    $cantidad = $_POST["cantidad_ejemplares"] ?? "";
    $id_categoria = $_POST["id_categoria"] ?? "";
    $id_editorial = $_POST["id_editorial"] ?? "";

    if ($titulo === "" || $isbn === "" || $cantidad === "" ||
        $id_categoria === "" || $id_editorial === "") {

        $mensaje = "Debe completar todos los campos obligatorios.";
        $tipo_mensaje = "error";

    } elseif (!is_numeric($cantidad) || (int)$cantidad < 1) {

        $mensaje = "La cantidad de ejemplares debe ser un número mayor o igual a 1.";
        $tipo_mensaje = "error";

    } else {

        $sql = "UPDATE libro SET
                    titulo = :titulo,
                    isbn = :isbn,
                    anio_publicacion = :anio_publicacion,
                    cantidad_ejemplares = :cantidad_ejemplares,
                    id_categoria = :id_categoria,
                    id_editorial = :id_editorial
                WHERE id_libro = :id_libro";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':titulo'               => $titulo,
                ':isbn'                 => $isbn,
                ':anio_publicacion'     => ($anio === "" ? null : (int)$anio),
                ':cantidad_ejemplares'  => (int)$cantidad,
                ':id_categoria'         => (int)$id_categoria,
                ':id_editorial'         => (int)$id_editorial,
                ':id_libro'             => $id_libro
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

$sql = "SELECT id_libro, titulo, isbn, anio_publicacion,
               cantidad_ejemplares, id_categoria, id_editorial
        FROM libro
        WHERE id_libro = :id_libro";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_libro' => $id]);
$libro = $stmt->fetch();

if (!$libro) {
    die("El libro solicitado no existe.");
}

$categorias = $pdo->query("SELECT id_categoria, nombre FROM categoria ORDER BY nombre")->fetchAll();
$editoriales = $pdo->query("SELECT id_editorial, nombre FROM editorial ORDER BY nombre")->fetchAll();
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
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Libros ]</a>
        <a href="alta.php">[ Nuevo libro ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
        <a href="../prestamo/listar.php">[ Préstamos ]</a>
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

        <label for="isbn">ISBN <span class="requerido">*</span></label>
        <input type="text" name="isbn" id="isbn" required
               value="<?= htmlspecialchars($libro['isbn']) ?>">

        <label for="anio_publicacion">Año de publicación</label>
        <input type="number" name="anio_publicacion" id="anio_publicacion"
               value="<?= htmlspecialchars((string)$libro['anio_publicacion']) ?>">

        <label for="cantidad_ejemplares">Cantidad de ejemplares <span class="requerido">*</span></label>
        <input type="number" name="cantidad_ejemplares" id="cantidad_ejemplares" min="1" required
               value="<?= $libro['cantidad_ejemplares'] ?>">

        <label for="id_categoria">Categoría <span class="requerido">*</span></label>
        <select name="id_categoria" id="id_categoria" required>
            <?php foreach ($categorias as $categoria) { ?>
                <option value="<?= $categoria['id_categoria'] ?>"
                    <?= $categoria['id_categoria'] == $libro['id_categoria'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($categoria['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_editorial">Editorial <span class="requerido">*</span></label>
        <select name="id_editorial" id="id_editorial" required>
            <?php foreach ($editoriales as $editorial) { ?>
                <option value="<?= $editorial['id_editorial'] ?>"
                    <?= $editorial['id_editorial'] == $libro['id_editorial'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($editorial['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>