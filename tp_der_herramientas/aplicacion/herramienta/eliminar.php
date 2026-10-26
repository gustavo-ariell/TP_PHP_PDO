<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {

    try {

        $check = $pdo->prepare("SELECT COUNT(*) AS t FROM detalle_prestamo WHERE id_herramienta = :id");
        $check->execute([':id' => (int)$_GET["id"]]);
        $f = $check->fetch();

        if ((int)$f["t"] > 0) {
            $mensaje = "No se puede eliminar: la herramienta está asociada a préstamos.";
            $tipo_mensaje = "error";
        } else {

            $stmt = $pdo->prepare("DELETE FROM herramienta WHERE id_herramienta = :id");
            $stmt->execute([':id' => (int)$_GET["id"]]);

            if ($stmt->rowCount() > 0) {
                $mensaje = "Herramienta eliminada correctamente.";
                $tipo_mensaje = "exito";
            } else {
                $mensaje = "La herramienta no existe.";
                $tipo_mensaje = "error";
            }
        }

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar la herramienta.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT h.id_herramienta, h.nombre, h.codigo_interno, c.nombre AS categoria
        FROM herramienta h
        LEFT JOIN categoria c ON h.id_categoria = c.id_categoria
        ORDER BY h.nombre";
$herramientas = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar herramienta</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>ELIMINAR HERRAMIENTA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar herramientas ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr><th>ID</th><th>Código</th><th>Nombre</th><th>Categoría</th><th>Acción</th></tr>
        </thead>
        <tbody>
            <?php foreach ($herramientas as $h): ?>
                <tr>
                    <td><?= $h['id_herramienta'] ?></td>
                    <td><?= htmlspecialchars($h['codigo_interno']) ?></td>
                    <td><?= htmlspecialchars($h['nombre']) ?></td>
                    <td><?= htmlspecialchars($h['categoria'] ?? '—') ?></td>
                    <td>
                        <a class="btn-eliminar" href="eliminar.php?id=<?= $h['id_herramienta'] ?>"
                           onclick="return confirm('¿Eliminar herramienta?');">Eliminar</a>
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