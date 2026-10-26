<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titulo = trim($_POST["titulo"] ?? "");
    $isbn = trim($_POST["isbn"] ?? "");
    $anio = $_POST["anio_publicacion"] ?? "";
    $cantidad = $_POST["cantidad_ejemplares"] ?? "";
    $id_categoria = $_POST["id_categoria"] ?? "";
    $id_editorial = $_POST["id_editorial"] ?? "";

    if ($titulo === "" || $isbn === "" || $cantidad === "" ||
        $id_categoria === "" || $id_editorial === "") {

        $mensaje = "Debe ingresar un título, un ISBN, la cantidad de ejemplares, una categoría y una editorial.";
        $tipo_mensaje = "error";

    } elseif (!is_numeric($cantidad) || (int)$cantidad < 1) {

        $mensaje = "La cantidad de ejemplares debe ser un número mayor o igual a 1.";
        $tipo_mensaje = "error";

    } elseif ($anio !== "" && (!is_numeric($anio) || (int)$anio < 0)) {

        $mensaje = "El año de publicación debe ser un número válido.";
        $tipo_mensaje = "error";

    } else {

        $sql = "INSERT INTO libro
                    (titulo, isbn, anio_publicacion, cantidad_ejemplares, id_categoria, id_editorial)
                VALUES
                    (:titulo, :isbn, :anio_publicacion, :cantidad_ejemplares, :id_categoria, :id_editorial)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':titulo'               => $titulo,
                ':isbn'                 => $isbn,
                ':anio_publicacion'     => ($anio === "" ? null : (int)$anio),
                ':cantidad_ejemplares'  => (int)$cantidad,
                ':id_categoria'         => (int)$id_categoria,
                ':id_editorial'         => (int)$id_editorial
            ]);

            $mensaje = "Libro registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el libro. Verifique que el ISBN no se repita.";
            $tipo_mensaje = "error";
        }
    }
}

$categorias = $pdo->query("SELECT id_categoria, nombre FROM categoria ORDER BY nombre")->fetchAll();
$editoriales = $pdo->query("SELECT id_editorial, nombre FROM editorial ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar libro</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Libros ]</a>
        <a href="alta.php">[ Nuevo libro ]</a>
        <a href="../autor/listar.php">[ Autores ]</a>
        <a href="../editorial/listar.php">[ Editoriales ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
        <a href="../prestamo/listar.php">[ Préstamos ]</a>
    </nav>
</header>

<main>

    <h2>Registrar libro</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="titulo">Título <span class="requerido">*</span></label>
        <input type="text" name="titulo" id="titulo" required
               value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>">

        <label for="isbn">ISBN <span class="requerido">*</span></label>
        <input type="text" name="isbn" id="isbn" required
               value="<?= htmlspecialchars($_POST['isbn'] ?? '') ?>">

        <label for="anio_publicacion">Año de publicación</label>
        <input type="number" name="anio_publicacion" id="anio_publicacion" min="0" max="2100"
               value="<?= htmlspecialchars($_POST['anio_publicacion'] ?? '') ?>">

        <label for="cantidad_ejemplares">Cantidad de ejemplares <span class="requerido">*</span></label>
        <input type="number" name="cantidad_ejemplares" id="cantidad_ejemplares" min="1" required
               value="<?= htmlspecialchars($_POST['cantidad_ejemplares'] ?? '1') ?>">

        <label for="id_categoria">Categoría <span class="requerido">*</span></label>
        <select name="id_categoria" id="id_categoria" required>
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categorias as $categoria) { ?>
                <option value="<?= $categoria['id_categoria'] ?>">
                    <?= htmlspecialchars($categoria['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_editorial">Editorial <span class="requerido">*</span></label>
        <select name="id_editorial" id="id_editorial" required>
            <option value="">Seleccione una editorial</option>
            <?php foreach ($editoriales as $editorial) { ?>
                <option value="<?= $editorial['id_editorial'] ?>">
                    <?= htmlspecialchars($editorial['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Registrar libro</button>

    </form>

    <p><a href="listar.php">Volver al listado de libros</a></p>

</main>

</body>
</html>