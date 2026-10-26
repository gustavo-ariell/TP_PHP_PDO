<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {

    try {

        $check = $pdo->prepare("SELECT COUNT(*) AS t FROM evaluacion WHERE id_evaluador = :id");
        $check->execute([':id' => (int)$_GET["id"]]);
        $f = $check->fetch();

        if ((int)$f["t"] > 0) {
            $mensaje = "No se puede eliminar: el evaluador tiene evaluaciones registradas.";
            $tipo_mensaje = "error";
        } else {

            $stmt = $pdo->prepare("DELETE FROM evaluador WHERE id_evaluador = :id");
            $stmt->execute([':id' => (int)$_GET["id"]]);

            if ($stmt->rowCount() > 0) {
                $mensaje = "Evaluador eliminado correctamente.";
                $tipo_mensaje = "exito";
            } else {
                $mensaje = "El evaluador no existe.";
                $tipo_mensaje = "error";
            }
        }

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el evaluador.";
        $tipo_mensaje = "error";
    }
}

$evaluadores = $pdo->query("SELECT * FROM evaluador ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar evaluador</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>ELIMINAR EVALUADOR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar evaluadores ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Acción</th></tr>
        </thead>
        <tbody>
            <?php foreach ($evaluadores as $e): ?>
                <tr>
                    <td><?= $e['id_evaluador'] ?></td>
                    <td><?= htmlspecialchars($e['nombre']) ?></td>
                    <td><?= htmlspecialchars($e['apellido']) ?></td>
                    <td>
                        <a class="btn-eliminar" href="eliminar.php?id=<?= $e['id_evaluador'] ?>"
                           onclick="return confirm('¿Eliminar evaluador?');">Eliminar</a>
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