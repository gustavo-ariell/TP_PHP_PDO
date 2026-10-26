<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_disciplina"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM disciplina WHERE id_disciplina = :id_disciplina";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_disciplina' => $id]);

        $mensaje = "Disciplina eliminada correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar la disciplina. Puede tener inscripciones asociadas.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre FROM disciplina WHERE id_disciplina = :id_disciplina";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_disciplina' => $id]);
$disciplina = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar disciplina</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE INSCRIPCIÓN A OLIMPIADAS ESCOLARES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Disciplinas ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar disciplina</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($disciplina && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar la disciplina
           <strong><?= htmlspecialchars($disciplina['nombre']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_disciplina" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de disciplinas</a></p>

    <?php } ?>

</main>

</body>
</html>