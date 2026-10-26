<?php
require_once "../conexion.php";

$categorias = $pdo->query("SELECT id_categoria, nombre FROM categoria ORDER BY nombre")->fetchAll();

$id_categoria = $_POST["id_categoria"] ?? "";
$libros = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_categoria !== "") {

    $sql = "SELECT
                l.titulo,
                l.descripcion,
                l.anio,
                l.archivo_digital,
                l.idioma,
                c.nombre AS categoria
            FROM libro_digital l
            LEFT JOIN categoria c ON l.id_categoria = c.id_categoria
            WHERE l.id_categoria = :id_categoria
            ORDER BY l.titulo";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_categoria' => (int)$id_categoria]);
    $libros = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libros por categoría</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="libros_por_categoria.php">[ Libros por categoría ]</a>
        <a href="descargas_por_libro.php">[ Descargas por libro ]</a>
        <a href="descargas_por_usuario.php">[ Descargas por usuario ]</a>
        <a href="../libro/listar.php">[ Libros ]</a>
    </nav>
</header>

<main>

    <h2>Libros por categoría</h2>

    <form action="libros_por_categoria.php" method="post">

        <label for="id_categoria">Categoría <span class="requerido">*</span></label>
        <select name="id_categoria" id="id_categoria" required>
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categorias as $categoria) { ?>
                <option value="<?= $categoria['id_categoria'] ?>"
                    <?= $categoria['id_categoria'] == $id_categoria ? "selected" : "" ?>>
                    <?= htmlspecialchars($categoria['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>

        <table>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Año</th>
                <th>Archivo</th>
                <th>Idioma</th>
            </tr>
            <?php foreach ($libros as $fila) { ?>
            <tr>
                <td><?= htmlspecialchars($fila['titulo']) ?></td>
                <td><?= htmlspecialchars((string)$fila['descripcion']) ?></td>
                <td><?= $fila['anio'] !== null ? $fila['anio'] : "—" ?></td>
                <td><?= htmlspecialchars((string)$fila['archivo_digital']) ?></td>
                <td><?= htmlspecialchars((string)$fila['idioma']) ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>