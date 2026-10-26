<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_prestamo = (int)($_POST["id_prestamo"] ?? 0);
    $fecha_devolucion_real = $_POST["fecha_devolucion_real"] ?? "";

    if ($fecha_devolucion_real === "") {

        $mensaje = "Debe ingresar la fecha de devolución.";
        $tipo_mensaje = "error";

    } else {

        $sql = "UPDATE prestamo
                SET fecha_devolucion_real = :fecha_devolucion_real
                WHERE id_prestamo = :id_prestamo";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':fecha_devolucion_real' => $fecha_devolucion_real,
                ':id_prestamo'           => $id_prestamo
            ]);

            $mensaje = "Devolución registrada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar la devolución.";
            $tipo_mensaje = "error";
        }
    }
}

$sql = "SELECT
            p.id_prestamo,
            p.fecha_prestamo,
            p.fecha_devolucion_estimada,
            l.titulo,
            e.nombre,
            e.apellido
        FROM prestamo p
        INNER JOIN libro l ON p.id_libro = l.id_libro
        INNER JOIN estudiante e ON p.id_estudiante = e.id_estudiante
        WHERE p.fecha_devolucion_real IS NULL
        ORDER BY p.fecha_devolucion_estimada";

$stmt = $pdo->query($sql);
$pendientes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar devoluciones</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Préstamos ]</a>
        <a href="alta.php">[ Nuevo préstamo ]</a>
        <a href="devolucion.php">[ Devoluciones ]</a>
        <a href="../libro/listar.php">[ Libros ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
    </nav>
</header>

<main>

    <h2>Registrar devoluciones</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <table>
        <tr>
            <th>Libro</th>
            <th>Estudiante</th>
            <th>Fecha de préstamo</th>
            <th>Devolución estimada</th>
            <th>Fecha de devolución real</th>
            <th>Acción</th>
        </tr>
        <?php foreach ($pendientes as $pendiente) { ?>
        <tr>
            <td><?= htmlspecialchars($pendiente['titulo']) ?></td>
            <td><?= htmlspecialchars($pendiente['nombre'] . " " . $pendiente['apellido']) ?></td>
            <td><?= htmlspecialchars($pendiente['fecha_prestamo']) ?></td>
            <td><?= htmlspecialchars((string)$pendiente['fecha_devolucion_estimada']) ?></td>
            <td>
                <form class="formulario-tabla" action="devolucion.php" method="post">
                    <input type="hidden" name="id_prestamo" value="<?= $pendiente['id_prestamo'] ?>">
                    <input type="date" name="fecha_devolucion_real" required>
            </td>
            <td>
                    <button type="submit">Registrar</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <p><a href="listar.php">Volver al listado de préstamos</a></p>

</main>

</body>
</html>