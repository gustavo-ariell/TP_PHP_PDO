<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");

    if ($nombre === "") {
        $mensaje = "Debe ingresar el nombre de la disciplina.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO disciplina (nombre, descripcion)
                VALUES (:nombre, :descripcion)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'      => $nombre,
                ':descripcion' => $descripcion
            ]);

            $mensaje = "Disciplina registrada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar la disciplina.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar disciplina</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE INSCRIPCIÓN A OLIMPIADAS ESCOLARES</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Disciplinas ]</a>
        <a href="alta.php">[ Nueva disciplina ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
        <a href="../inscripcion/listar.php">[ Inscripciones ]</a>
    </nav>
</header>

<main>

    <h2>Registrar disciplina</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="4"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>

        <button type="submit">Registrar disciplina</button>

    </form>

    <p><a href="listar.php">Volver al listado de disciplinas</a></p>

</main>

</body>
</html>