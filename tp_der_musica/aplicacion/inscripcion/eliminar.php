<?php
require_once "../conexion.php";

$mensaje = "";
$error   = "";

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {

    try {

        $stmt = $pdo->prepare("DELETE FROM inscripcion WHERE id_inscripcion = :id");
        $stmt->execute([":id" => $_GET["id"]]);

        if ($stmt->rowCount() > 0) {
            $mensaje = "Inscripción eliminada correctamente.";
        } else {
            $error = "La inscripción no existe.";
        }

    } catch (PDOException $e) {
        $error = "No se pudo eliminar la inscripción.";
    }
}

$sql = "SELECT ins.id_inscripcion, ins.fecha_inscripcion,
               e.nombre AS est_nombre, e.apellido AS est_apellido,
               i.nombre AS instrumento, c.dia, c.horario
        FROM inscripcion ins
        INNER JOIN estudiante e ON ins.id_estudiante = e.id_estudiante
        INNER JOIN curso c ON ins.id_curso = c.id_curso
        INNER JOIN instrumento i ON c.id_instrumento = i.id_instrumento
        ORDER BY ins.id_inscripcion DESC";
$inscripciones = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar inscripción</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>ELIMINAR INSCRIPCIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar inscripciones ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje exito"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <?php if ($error !== ""): ?>
        <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr><th>ID</th><th>Estudiante</th><th>Curso</th><th>Fecha</th><th>Acción</th></tr>
        </thead>
        <tbody>
            <?php foreach ($inscripciones as $ins): ?>
                <tr>
                    <td><?= $ins['id_inscripcion'] ?></td>
                    <td><?= htmlspecialchars($ins['est_apellido'] . ", " . $ins['est_nombre']) ?></td>
                    <td><?= htmlspecialchars($ins['instrumento'] . " (" . $ins['dia'] . " " . $ins['horario'] . ")") ?></td>
                    <td><?= htmlspecialchars($ins['fecha_inscripcion']) ?></td>
                    <td>
                        <a class="btn-eliminar" href="eliminar.php?id=<?= $ins['id_inscripcion'] ?>"
                           onclick="return confirm('¿Eliminar inscripción?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>