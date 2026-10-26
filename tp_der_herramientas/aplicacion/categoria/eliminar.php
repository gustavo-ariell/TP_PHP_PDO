<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {

    try {

        $check = $pdo->prepare("SELECT COUNT(*) AS t FROM herramienta WHERE id_categoria = :id");
        $check->execute([':id' => (int)$_GET["id"]]);
        $f = $check->fetch();

        if ((int)$f["t"] > 0) {
            $mensaje = "No se puede eliminar: la categoría tiene herramientas asociadas.";
            $tipo_mensaje = "error";
        } else {

            $stmt = $pdo->prepare("DELETE FROM categoria WHERE<a href="listar.php">[ Listar categorías ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <h2>Nueva categoría</h2>

    <form action="alta.php" method="POST">
        <label>Nombre <span class="requerido">*</span></label>
        <input type="text" name id_categoria = :id");
            $stmt->execute([':id' => (int)$_GET["id"]]);

            if ($stmt->rowCount() > 0) {
                $mensaje = "Categoría eliminada correctamente.";
                $tipo_mensaje = "exito";
            } else {
                $mensaje = "La categoría no existe.";
                $tipo_mensaje = "error";
            }
        }

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar la categoría.";
        $tipo_mensaje = "error";
    }
}

$categorias = $pdo->query("SELECT * FROM categoria ORDER BY nombre")->fetchAll();
?>
 type="submit">Registrar<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar categoría</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>ELIMINAR CATEGORÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar categorías ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            </option>
            <option value="prestada" <?= ($_POST['estado'] ?? '') === 'prestada' ? 'selected' : '' ?>>Prestada</option>
            <option value="en reparacion" <?= ($_POST['estado'] ?? '') === 'en reparacion' ? 'selected' : '' ?>>En reparación</option>
        </select>

        <label>Categoría <span class="requerido">*</span></label>
        <select name="id_categoria" required>
            <option<tr><th>ID</th><th>Nombre</th><th>Acción</th></tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $c): ?>
                <tr>
                    <td><?= $c['id_categoria'] ?></td>
                    <td><?= htmlspecialchars($c['nombre']) ?></td>
                    <td>
                        <a class="btn-eliminar" href="eliminar.php?id=<?= $c['id_categoria'] ?>"
                           onclick="return confirm('¿Eliminar categoría?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Préstamos de Herramientas</p>
</footer>

</body>
</html>