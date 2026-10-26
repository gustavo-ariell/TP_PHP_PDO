<?php
require_once "../conexion.php";

$usuarios = $pdo->query("SELECT id_usuario, nombre, apellido, email FROM usuario ORDER BY apellido")->fetchAll();

$id_usuario = $_POST["id_usuario"] ?? "";
$descargas = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_usuario !== "") {

    $sql = "SELECT
                d.fecha_descarga,
                d.dispositivo,
                l.titulo,
                l.idioma
            FROM descarga d
            INNER JOIN usuario u ON d.id_usuario = u.id_usuario
            INNER JOIN libro_digital l ON d.id_libro = l.id_libro
            WHERE d.id_usuario = :id_usuario
            ORDER BY d.fecha_descarga DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_usuario' => (int)$id_usuario]);
    $descargas = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Descargas por usuario</title>
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

    <h2>Descargas por usuario</h2>

    <form action="descargas_por_usuario.php" method="post">

        <label for="id_usuario">Usuario <span class="requerido">*</span></label>
        <select name="id_usuario" id="id_usuario" required>
            <option value="">Seleccione un usuario</option>
            <?php foreach ($usuarios as $usuario) { ?>
                <option value="<?= $usuario['id_usuario'] ?>"
                    <?= $usuario['id_usuario'] == $id_usuario ? "selected" : "" ?>>
                    <?= htmlspecialchars($usuario['apellido'] . ", " . $usuario['nombre'] . " (" . $usuario['email'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>

        <table>
            <tr>
                <th>Libro</th>
                <th>Fecha y hora</th>
                <th>Dispositivo</th>
                <th>Idioma</th>
            </tr>
            <?php foreach ($descargas as $fila) { ?>
            <tr>
                <td><?= htmlspecialchars($fila['titulo']) ?></td>
                <td><?= htmlspecialchars($fila['fecha_descarga']) ?></td>
                <td><?= htmlspecialchars((string)$fila['dispositivo']) ?></td>
                <td><?= htmlspecialchars((string)$fila['idioma']) ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>