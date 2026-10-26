<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {

    try {

        // Eliminar asociaciones de autores
        $del1 = $pdo->prepare("DELETE FROM articulo_autor WHERE id_articulo = :id");
        $del1->execute([':id' => (int)$_GET["id"]]);

        // Eliminar evaluaciones
        $del2 = $pdo->prepare("DELETE FROM evaluacion WHERE id_articulo = :id");
        $del2->execute([':id' => (int)$_GET["id"]]);

        // Eliminar artículo
        $del3 = $pdo->prepare("DELETE FROM articulo WHERE id_articulo = :id");
        $del3->execute([':id' => (int)$_GET["id"]]);

        if ($del3->rowCount() > 0) {
            $mensaje = "Artículo eliminado correctamente.";
            $tipo_mensaje = "exito";
        } else {
            $mensaje = "El artículo no existe.";
            $tipo_mensaje = "error";
        }

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el artículo.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT ar.id_articulo, ar.titulo, ar.fecha_envio,
               s.nombre AS seccion, e.nombre AS estado
        FROM articulo ar
        INNER JOIN seccion s ON ar.id_seccion = s.id_seccion
        INNER JOIN estado_articulo e ON ar.id_estado = e.id_estado
        ORDER BY ar.id_articulo DESC";
$articulos = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar artículo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>ELIMINAR ARTÍCULO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar artículos ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr><th>ID</th><th>Título</th><th>Fecha</th><th>Estado</th><th>Acción</th></tr>
        </thead>
        <tbody>
            <?php foreach ($articulos as $a): ?>
                <tr>
                    <td><?= $a['id_articulo'] ?></td>
                    <td><?= htmlspecialchars($a['titulo']) ?></td>
                    <td><?= htmlspecialchars($a['fecha_envio']) ?></td>
                    <td><?= htmlspecialchars($a['estado']) ?></td>
                    <td>
                        <a class="btn-eliminar" href="eliminar.php?id=<?= $a['id_articulo'] ?>"
                           onclick="return confirm('¿Eliminar artículo?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>