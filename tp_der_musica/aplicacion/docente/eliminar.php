<?php
require_once "../conexion.php";

$mensaje = "";
$error   = "";

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {

    try {

        $check = $pdo->prepare("SELECT COUNT(*) AS total FROM curso WHERE id_docente = :id");
        $check->execute([":id" => $_GET["id"]]);
        $fila = $check->fetch();

        if ((int)$fila["total"] > 0) {
            $error = "No se puede eliminar: el docente tiene cursos asignados.";
        } else {

            $stmt = $pdo->prepare("DELETE FROM docente WHERE id_docente = :id");
            $stmt->execute([":id" => $_GET["id"]]);

            if ($stmt->rowCount() > 0) {
                $mensaje = "Docente eliminado correctamente.";
            } else {
                $error = "El docente no existe.";
            }
        }

    } catch (PDOException $e) {
        $error = "No se pudo eliminar el docente.";
    }
}

$sql = "SELECT d.id_docente, d.nombre, d.apellido, i.nombre AS instrumento
        FROM docente d
        INNER JOIN instrumento i ON d.id_instrumento = i.id_instrumento
        ORDER BY d.apellido";
$docentes = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar docente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>ELIMINAR DOCENTE</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar docentes ]</a>
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
            <tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Instrumento</th><th>Acción</th></tr>
        </thead>
        <tbody>
            <?php foreach ($docentes as $doc): ?>
                <tr>
                    <td><?= $doc['id_docente'] ?></td>
                    <td><?= htmlspecialchars($doc['nombre']) ?></td>
                    <td><?= htmlspecialchars($doc['apellido']) ?></td>
                    <td><?= htmlspecialchars($doc['instrumento']) ?></td>
                    <td>
                        <a class="btn-eliminar" href="eliminar.php?id=<?= $doc['id_docente'] ?>"
                           onclick="return confirm('¿Eliminar docente?');">Eliminar</a>
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