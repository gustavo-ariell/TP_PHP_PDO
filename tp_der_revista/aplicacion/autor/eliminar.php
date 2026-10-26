<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {

    try {

        $check = $pdo->prepare("SELECT COUNT(*) AS t FROM articulo_autor WHERE id_autor = :id");
        $check->execute([':id' => (int)$_GET["id"]]);
        $f = $check->fetch();

        if ((int)$f["t"] > 0) {
            $mensaje = "No se puede eliminar: el autor está asociado a artículos.";
            $tipo_mensaje = "error";
        } else {

            $stmt = $pdo->prepare("DELETE FROM autor WHERE id_autor = :id");
            $stmt->execute([':id' => (int)$_GET["id"]]);

            if ($stmt->rowCount() > 0) {
                $mensaje = "Autor eliminado correctamente.";
                $tipo_mensaje = "exito";
            } else {
                $mensaje = "El autor no existe.";
                $tipo_mensaje = "error";
            }
        }

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el autor.";
        $tipo_mensaje = "error";
    }
}

$autores = $pdo->query("SELECT * FROM autor ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar autor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>ELIMINAR AUTOR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar autores ]</a>
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
            <?php foreach ($autores as $a): ?>
                <tr>
                    <td><?= $a['id_autor'] ?></td>
                    <td><?= htmlspecialchars($a['nombre']) ?></td>
                    <td><?= htmlspecialchars($a['apellido']) ?></td>
                    <td>
                        <a class="btn-eliminar" href="eliminar.php?id=<?= $a['id_autor'] ?>"
                           onclick="return confirm('¿Eliminar autor?');">Eliminar</a>
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