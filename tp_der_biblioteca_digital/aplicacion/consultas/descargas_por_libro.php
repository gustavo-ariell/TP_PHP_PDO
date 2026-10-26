<?php
require_once "../conexion.php";

$libros = $pdo->query("SELECT id_libro, titulo FROM libro_digital ORDER BY titulo")->fetchAll();

$id_libro = $_POST["id_libro"] ?? "";
$descargas = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_libro !== "") {

    $sql = "SELECT
                d.fecha_descarga,
                d.dispositivo,
                u.nombre AS nombre_usuario,
                u.apellido AS apellido_usuario,
                u.email,
                l.titulo
            FROM descarga d
            INNER JOIN usuario u ON d.id_usuario = u.id_usuario
            INNER JOIN libro_digital l ON d.id_libro = l.id_libro
            WHERE d.id_libro = :id_libro
            ORDER BY d.fecha_descarga DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_libro' => (int)$id_libro]);
    $descargas = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Descargas por libro</title>
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
        <a href="../descarga/listar.php">[ Descargas ]</a>
    </nav>
</header>

<main>

    <h2>Descargas por libro</h2>

    <form action="descargas_por_libro.php" method="post">

        <label for="id_libro">Libro <span class="requerido">*</span></label>
        <select name="id_libro" id="id_libro" required>
            <option value="">Seleccione un libro</option>
            <?php foreach ($libros as $libro) { ?>
                <option value="<?= $libro['id_libro'] ?>"
                    <?= $libro['id_libro'] == $id_libro ? "selected" : "" ?>>
                    <?= htmlspecialchars($libro['titulo']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>

        <table>
            <tr>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Fecha y hora</th>
                <th>Dispositivo</th>
            </tr>
            <?php foreach ($descargas as $fila) { ?>
            <tr>
                <td><?= htmlspecialchars($fila['apellido_usuario'] . ", " . $fila['nombre_usuario']) ?></td>
                <td><?= htmlspecialchars($fila['email']) ?></td>
                <td><?= htmlspecialchars($fila['fecha_descarga']) ?></td>
                <td><?= htmlspecialchars((string)$fila['dispositivo']) ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>