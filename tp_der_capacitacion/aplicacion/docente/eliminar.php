<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_docente"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM docente WHERE id_docente = :id_docente";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_docente' => $id]);

        $mensaje = "Docente eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el docente. Puede tener cursos asociados.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre, apellido FROM docente WHERE id_docente = :id_docente";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_docente' => $id]);
$docente = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar docente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE CURSOS DE CAPACITACIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Docentes ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar docente</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($docente && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar al docente
           <strong><?= htmlspecialchars($docente['nombre'] . " " . $docente['apellido']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_docente" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de docentes</a></p>

    <?php } ?>

</main>

</body>
</html>