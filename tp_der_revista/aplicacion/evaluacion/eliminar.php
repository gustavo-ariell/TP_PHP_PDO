<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {

    try {

        $stmt = $pdo->prepare("DELETE FROM evaluacion WHERE id_evaluacion = :id");
        $stmt->execute([':id' => (int)$_GET["id"]]);

        if ($stmt->rowCount() > 0) {
            $mensaje = "Evaluación eliminada correctamente.";
            $tipo_mensaje = "exito";
        } else {
            $mensaje = "La evaluación no existe.";
            $tipo_mensaje = "error";
        }

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar la evaluación.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT ev.id_evaluacion, ev.fecha, ev.dictamen,
               ar.titulo, eva.nombre, eva.apellido
        FROM evaluacion ev
        INNER JOIN articulo ar ON ev.id_articulo = ar.id_articulo
        INNER JOIN evaluador eva ON ev.id_evaluador = eva.id_evaluador
        ORDER BY ev.id_evaluacion DESC";
$evaluaciones = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar evaluación</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>ELIMINAR EVALUACIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar evaluaciones ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr><th>#</th><th>Artículo</th><th>Evaluador</th><th>Dictamen</th><th>Acción</th></tr>
        </thead>
        <tbody>
            <?php foreach ($evaluaciones as $ev): ?>
                <tr>
                    <td><?= $ev['id_evaluacion'] ?></td>
                    <td><?= htmlspecialchars($ev['titulo']) ?></td>
                    <td><?= htmlspecialchars($ev['apellido'] . ", " . $ev['nombre']) ?></td>
                    <td><?= htmlspecialchars($ev['dictamen']) ?></td>
                    <td>
                        <a class="btn-eliminar" href="eliminar.php?id=<?= $ev['id_evaluacion'] ?>"
                           onclick="return confirm('¿Eliminar evaluación?');">Eliminar</a>
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