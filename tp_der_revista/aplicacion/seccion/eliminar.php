<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {

    try {

        $check = $pdo->prepare("SELECT COUNT(*) AS t FROM articulo WHERE id_seccion = :id");
        $check->execute([':id' => (int)$_GET["id"]]);
        $f = $check->fetch();

        if ((int)$f["t"] > 0) {
            $mensaje = "No se puede eliminar: la sección tiene artículos asociados.";
            $tipo_mensaje = "error";
        } else {

            $stmt = $pdo->prepare("DELETE FROM seccion WHERE id_seccion = :id");
            $stmt->execute([':id' => (int)$_GET["id"]]);

            if ($stmt->rowCount() > 0) {
                $mensaje = "Sección eliminada correctamente.";
                $tipo_mensaje = "exito";
            } else {
                $mensaje = "La sección no existe.";
                $tipo_mensaje = "error";
            }
        }

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar la sección.";
        $tipo_mensaje = "error";
    }
}

$secciones = $pdo->query("SELECT * FROM seccion ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar sección</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>ELIMINAR SECCIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar secciones ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr><th>ID</th><th>Nombre</th><th>Acción</th></tr>
        </thead>
        <tbody>
            <?php foreach ($secciones as $s): ?>
                <tr>
                    <td><?= $s['id_seccion'] ?></td>
                    <td><?= htmlspecialchars($s['nombre']) ?></td>
                    <td>
                        <a class="btn-eliminar"
                           href="eliminar.php?id=<?= $s['id_seccion'] ?>"
                           onclick="return confirm('¿Eliminar sección?');">Eliminar</a>
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