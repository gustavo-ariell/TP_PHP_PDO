<?php
require_once "../conexion.php";

$mensaje = "";
$error   = "";

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {

    try {

        // Verificar uso en docentes o cursos
        $check1 = $pdo->prepare("SELECT COUNT(*) AS t FROM docente WHERE id_instrumento = :id");
        $check1->execute([":id" => $_GET["id"]]);
        $f1 = $check1->fetch();

        $check2 = $pdo->prepare("SELECT COUNT(*) AS t FROM curso WHERE id_instrumento = :id");
        $check2->execute([":id" => $_GET["id"]]);
        $f2 = $check2->fetch();

        if ((int)$f1["t"] > 0 || (int)$f2["t"] > 0) {
            $error = "No se puede eliminar: el instrumento está en uso por docentes o cursos.";
        } else {

            $stmt = $pdo->prepare("DELETE FROM instrumento WHERE id_instrumento = :id");
            $stmt->execute([":id" => $_GET["id"]]);

            if ($stmt->rowCount() > 0) {
                $mensaje = "Instrumento eliminado correctamente.";
            } else {
                $error = "El instrumento no existe.";
            }
        }

    } catch (PDOException $e) {
        $error = "No se pudo eliminar el instrumento.";
    }
}

$instrumentos = $pdo->query("SELECT * FROM instrumento ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar instrumento</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>ELIMINAR INSTRUMENTO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar instrumentos ]</a>
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
            <tr><th>ID</th><th>Nombre</th><th>Acción</th></tr>
        </thead>
        <tbody>
            <?php foreach ($instrumentos as $inst): ?>
                <tr>
                    <td><?= $inst['id_instrumento'] ?></td>
                    <td><?= htmlspecialchars($inst['nombre']) ?></td>
                    <td>
                        <a class="btn-eliminar" href="eliminar.php?id=<?= $inst['id_instrumento'] ?>"
                           onclick="return confirm('¿Eliminar instrumento?');">Eliminar</a>
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