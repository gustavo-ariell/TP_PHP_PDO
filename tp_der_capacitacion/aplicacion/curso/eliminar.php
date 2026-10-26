<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_curso"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM curso WHERE id_curso = :id_curso";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_curso' => $id]);

        $mensaje = "Curso eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el curso. Puede tener inscripciones asociadas.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre FROM curso WHERE id_curso = :id_curso";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_curso' => $id]);
$curso = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar curso</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE CURSOS DE CAPACITACIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Cursos ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar curso</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($curso && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar el curso
           <strong><?= htmlspecialchars($curso['nombre']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_curso" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de cursos</a></p>

    <?php } ?>

</main>

</body>
</html>