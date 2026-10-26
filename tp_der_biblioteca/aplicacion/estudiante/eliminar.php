<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_estudiante"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM estudiante WHERE id_estudiante = :id_estudiante";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_estudiante' => $id]);

        $mensaje = "Estudiante eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el estudiante. Puede tener préstamos asociados.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre, apellido FROM estudiante WHERE id_estudiante = :id_estudiante";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_estudiante' => $id]);
$estudiante = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar estudiante</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Estudiantes ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar estudiante</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($estudiante && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar al estudiante
           <strong><?= htmlspecialchars($estudiante['nombre'] . " " . $estudiante['apellido']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_estudiante" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de estudiantes</a></p>

    <?php } ?>

</main>

</body>
</html>