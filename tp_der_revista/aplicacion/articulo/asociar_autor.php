<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_articulo = $_POST["id_articulo"] ?? "";
    $id_autor    = $_POST["id_autor"] ?? "";

    if (!ctype_digit($id_articulo) || !ctype_digit($id_autor)) {
        $mensaje = "Debe seleccionar un artículo y un autor.";
        $tipo_mensaje = "error";
    } else {

        try {

            $check = $pdo->prepare("SELECT COUNT(*) AS t FROM articulo_autor
                                    WHERE id_articulo = :id_articulo AND id_autor = :id_autor");
            $check->execute([
                ':id_articulo' => (int)$id_articulo,
                ':id_autor'    => (int)$id_autor
            ]);
            $f = $check->fetch();

            if ((int)$f["t"] > 0) {
                $mensaje = "El autor ya está asociado a ese artículo.";
                $tipo_mensaje = "error";
            } else {

                $stmt = $pdo->prepare("INSERT INTO articulo_autor (id_articulo, id_autor)
                                       VALUES (:id_articulo, :id_autor)");
                $stmt->execute([
                    ':id_articulo' => (int)$id_articulo,
                    ':id_autor'    => (int)$id_autor
                ]);

                $mensaje = "Autor asociado al artículo correctamente.";
                $tipo_mensaje = "exito";
            }

        } catch (PDOException $e) {
            $mensaje = "No se pudo asociar el autor.";
            $tipo_mensaje = "error";
        }
    }
}

$articulos = $pdo->query("SELECT id_articulo, titulo FROM articulo ORDER BY titulo")->fetchAll();
$autores   = $pdo->query("SELECT id_autor, nombre, apellido FROM autor ORDER BY apellido")->fetchAll();

$sqlAsoc = "SELECT aa.id_articulo, aa.id_autor,
                   ar.titulo,
                   au.nombre AS autor_nombre, au.apellido AS autor_apellido
            FROM articulo_autor aa
            INNER JOIN articulo ar ON aa.id_articulo = ar.id_articulo
            INNER JOIN autor au ON aa.id_autor = au.id_autor
            ORDER BY ar.titulo, au.apellido";
$asociaciones = $pdo->query($sqlAsoc)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asociar autores a artículos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>ASOCIAR AUTORES A ARTÍCULOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar artículos ]</a>
        <a href="asociar_evaluador.php">[ Asociar evaluadores ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <h2>Nueva asociación</h2>

    <form action="asociar_autor.php" method="POST">

        <label>Artículo <span class="requerido">*</span></label>
        <select name="id_articulo" required>
            <option value="">-- Seleccione un artículo --</option>
            <?php foreach ($articulos as $a): ?>
                <option value="<?= $a['id_articulo'] ?>"><?= htmlspecialchars($a['titulo']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Autor <span class="requerido">*</span></label>
        <select name="id_autor" required>
            <option value="">-- Seleccione un autor --</option>
            <?php foreach ($autores as $au): ?>
                <option value="<?= $au['id_autor'] ?>">
                    <?= htmlspecialchars($au['apellido'] . ", " . $au['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Asociar</button>

    </form>

    <h2>Asociaciones actuales</h2>

    <?php if (count($asociaciones) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Artículo</th>
                    <th>Autor</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($asociaciones as $asoc): ?>
                    <tr>
                        <td><?= htmlspecialchars($asoc['titulo']) ?></td>
                        <td><?= htmlspecialchars($asoc['autor_apellido'] . ", " . $asoc['autor_nombre']) ?></td>
                        <td>
                            <a class="btn-eliminar"
                               href="desasociar_autor.php?id_articulo=<?= $asoc['id_articulo'] ?>&id_autor=<?= $asoc['id_autor'] ?>"
                               onclick="return confirm('¿Quitar asociación?');">Quitar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">No hay asociaciones registradas.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>