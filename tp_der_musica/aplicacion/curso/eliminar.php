<?php
require_once "../conexion.php";

$mensaje = "";
$error   = "";

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {

    try {

        $check = $pdo->prepare("SELECT COUNT(*) AS t FROM inscripcion WHERE id_curso = :id");
        $check->execute([":id" => $_GET["id"]]);
        $f = $check->fetch();

        if ((int)$f["t"] > 0) {
            $error = "No se puede eliminar: el curso tiene inscripciones registradas.";
        } else {

            $stmt = $pdo->prepare("DELETE FROM curso WHERE id_curso = :id");
            $stmt->execute([":id" => $_GET["id"]]);

            if ($stmt->rowCount() > 0) {
                $mensaje = "Curso eliminado correctamente.";
            } else {
                $error = "El curso no existe.";
            }
        }

    } catch (PDOException $e) {
        $error = "No se pudo eliminar el curso.";
    }
}

$sql = "SELECT c.id_curso, c.dia, c.horario,
               i.nombre AS instrumento,
               d.apellido AS docente_apellido, d.nombre AS docente_nombre
        FROM curso c
        INNER JOIN instrumento i ON c.id_instrumento = i.id_instrumento
        INNER JOIN docente d ON c.id_docente = d.id_docente
        ORDER BY c.dia, c.horario";
$cursos = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar curso</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>ELIMINAR CURSO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar cursos ]</a>
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
            <tr><th>ID</th><th>Instrumento</th><th>Docente</th><th>Día</th><th>Horario</th><th>Acción</th></tr>
        </thead>
        <tbody>
            <?php foreach ($cursos as $cur): ?>
                <tr>
                    <td><?= $cur['id_curso'] ?></td>
                    <td><?= htmlspecialchars($cur['instrumento']) ?></td>
                    <td><?= htmlspecialchars($cur['docente_apellido'] . ", " . $cur['docente_nombre']) ?></td>
                    <td><?= htmlspecialchars($cur['dia']) ?></td>
                    <td><?= htmlspecialchars($cur['horario']) ?></td>
                    <td>
                        <a class="btn-eliminar" href="eliminar.php?id=<?= $cur['id_curso'] ?>"
                           onclick="return confirm('¿Eliminar curso?');">Eliminar</a>
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