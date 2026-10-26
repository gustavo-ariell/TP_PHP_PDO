<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_descarga"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM descarga WHERE id_descarga = :id_descarga";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_descarga' => $id]);

        $mensaje = "Descarga eliminada correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar la descarga.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT
            d.fecha_descarga,
            d.dispositivo,
            u.nombre AS nombre_usuario,
            u.apellido AS apellido_usuario,
            l.titulo
        FROM descarga d
        INNER JOIN usuario u ON d.id_usuario = u.id_usuario
        INNER JOIN libro_digital l ON d.id_libro = l.id_libro
        WHERE d.id_descarga = :id_descarga";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_descarga' => $id]);
$descarga = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar descarga</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Descargas ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar descarga</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($descarga && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar la descarga de
           <strong><?= htmlspecialchars($descarga['nombre_usuario'] . " " . $descarga['apellido_usuario']) ?></strong>
           del libro <strong><?= htmlspecialchars($descarga['titulo']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_descarga" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de descargas</a></p>

    <?php } ?>

</main>

</body>
</html>