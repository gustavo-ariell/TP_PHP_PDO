<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titulo = trim($_POST["titulo"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $anio = trim($_POST["anio"] ?? "");
    $archivo_digital = trim($_POST["archivo_digital"] ?? "");
    $idioma = trim($_POST["idioma"] ?? "");
    $id_categoria = $_POST["id_categoria"] ?? "";

    if ($titulo === "") {
        $mensaje = "Debe ingresar el título del libro.";
        $tipo_mensaje = "error";
    } elseif ($anio !== "" && (!is_numeric($anio) || (int)$anio < 1000 || (int)$anio > 2100)) {
        $mensaje = "El año debe ser un número válido entre 1000 y 2100.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO libro_digital (titulo, descripcion, anio, archivo_digital, idioma, id_categoria)
                VALUES (:titulo, :descripcion, :anio, :archivo_digital, :idioma, :id_categoria)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':titulo'          => $titulo,
                ':descripcion'     => $descripcion,
                ':anio'            => ($anio === "" ? null : (int)$anio),
                ':archivo_digital' => $archivo_digital,
                ':idioma'          => $idioma,
                ':id_categoria'    => ($id_categoria === "" ? null : (int)$id_categoria)
            ]);

            $id_libro = $pdo->lastInsertId();

            header("Location: asociar.php?id=" . $id_libro);
            exit;

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el libro.";
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
    <title>Registrar libro digital</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Libros ]</a>
        <a href="alta.php">[ Nuevo libro ]</a>
        <a href="../autor/listar.php">[ Autores ]</a>
        <a href="../categoria/listar.php">[ Categorías ]</a>
        <a href="../usuario/listar.php">[ Usuarios ]</a>
    </nav>
</header>

<main>

    <h2>Registrar libro digital</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="titulo">Título <span class="requerido">*</span></label>
        <input type="text" name="titulo" id="titulo" required
               value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>

        <label for="anio">Año de publicación</label>
        <input type="number" name="anio" id="anio" min="1000" max="2100"
               value="<?= htmlspecialchars($_POST['anio'] ?? '') ?>">

        <label for="archivo_digital">Archivo digital</label>
        <input type="text" name="archivo_digital" id="archivo_digital" placeholder="ejemplo.pdf"
               value="<?= htmlspecialchars($_POST['archivo_digital'] ?? '') ?>">

        <label for="idioma">Idioma</label>
        <input type="text" name="idioma" id="idioma"
               value="<?= htmlspecialchars($_POST['idioma'] ?? 'Español') ?>">

        <label for="id_categoria">Categoría</label>
        <select name="id_categoria" id="id_categoria">
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categorias as $categoria) { ?>
                <option value="<?= $categoria['id_categoria'] ?>"
                    <?= ($_POST['id_categoria'] ?? '') == $categoria['id_categoria'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($categoria['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Registrar libro y asociar autores</button>

    </form>

    <p><a href="listar.php">Volver al listado de libros</a></p>

</main>

</body>
</html>