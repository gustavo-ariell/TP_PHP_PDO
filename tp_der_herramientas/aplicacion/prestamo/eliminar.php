<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {

    try {

        // Devolver herramientas a disponible
        $upd = $pdo->prepare("UPDATE herramienta
                              SET estado = 'disponible'
                              WHERE id_herramienta IN (
                                  SELECT id_herramienta FROM detalle_prestamo
                                  WHERE id_prestamo = :id
                              )");
        $upd->execute([':id' => (int)$_GET["id"]]);

        // Eliminar detalles
        $delDet = $pdo->prepare("DELETE FROM detalle_prestamo WHERE id_prestamo = :id");
        $delDet->execute([':id' => (int)$_GET["id"]]);

        // Eliminar préstamo
        $delPre = $pdo->prepare("DELETE FROM prestamo WHERE id_prestamo = :id");
        $delPre->execute([':id' => (int)$_GET["id"]]);

        if ($delPre->rowCount() > 0) {
            $mensaje = "Préstamo eliminado correctamente.";
            $tipo_mensaje = "exito";
        } else {
            $mensaje = "El préstamo no existe.";
            $tipo_mensaje = "error";
        }

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el préstamo.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT pe.id_prestamo, pe.fecha_prestamo, pe.estado,
               pr.nombre, pr.apellido
        FROM prestamo pe
        INNER JOIN persona pr ON pe.id_persona = pr.id_persona
        ORDER BY pe.id_prestamo DESC";
$prestamos = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar préstamo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>ELIMINAR PRÉSTAMO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar préstamos ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr><th>ID</th><th>Persona</th><th>Fecha</th><th>Estado</th><th>Acción</th></tr>
        </thead>
        <tbody>
            <?php foreach ($prestamos as $pe): ?>
                <tr>
                    <td><?= $pe['id_prestamo'] ?></td>
                    <td><?= htmlspecialchars($pe['apellido'] . ", " . $pe['nombre']) ?></td>
                    <td><?= htmlspecialchars($pe['fecha_prestamo']) ?></td>
                    <td><?= htmlspecialchars($pe['estado']) ?></td>
                    <td>
                        <a class="btn-eliminar" href="eliminar.php?id=<?= $pe['id_prestamo'] ?>"
                           onclick="return confirm('¿Eliminar préstamo?');">Eliminar</a>
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