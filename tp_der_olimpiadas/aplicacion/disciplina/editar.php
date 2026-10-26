<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_disciplina = (int)($_POST["id_disciplina"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");

    if ($nombre === "") {
        $mensaje = "Debe ingresar el nombre de la disciplina.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE disciplina SET
                    nombre = :nombre,
                    descripcion = :descripcion
                WHERE id_disciplina = :id_disciplina";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'        => $nombre,
                ':descripcion'   => $descripcion,
                ':id_disciplina' => $id_disciplina
            ]);

            $mensaje = "Disciplina modificada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar la disciplina.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_disciplina"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_disciplina, nombre, descripcion
        FROM disciplina
        WHERE id_disciplina = :id_disciplina";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_disciplina' => $id]);
$disciplina = $stmt->fetch();

if (!$disciplina) {
    die("La disciplina solicitada no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar disciplina</title>
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

    <h2>Modificar información de la disciplina</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_disciplina" value="<?= $disciplina['id_disciplina'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($disciplina['nombre']) ?>">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="4"><?= htmlspecialchars((string)$disciplina['descripcion']) ?></textarea>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>