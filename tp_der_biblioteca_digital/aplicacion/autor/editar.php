<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_autor = (int)($_POST["id_autor"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $nacionalidad = trim($_POST["nacionalidad"] ?? "");

    if ($nombre === "" || $apellido === "") {
        $mensaje = "Debe ingresar un nombre y un apellido.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE autor SET
                    nombre = :nombre,
                    apellido = :apellido,
                    nacionalidad = :nacionalidad
                WHERE id_autor = :id_autor";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'       => $nombre,
                ':apellido'     => $apellido,
                ':nacionalidad' => $nacionalidad,
                ':id_autor'     => $id_autor
            ]);

            $mensaje = "Autor modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el autor.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_autor"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_autor, nombre, apellido, nacionalidad
        FROM autor WHERE id_autor = :id_autor";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_autor' => $id]);
$autor = $stmt->fetch();

if (!$autor) {
    die("El autor solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar autor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Autores ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del autor</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_autor" value="<?= $autor['id_autor'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($autor['nombre']) ?>">

        <label for="apellido">Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" id="apellido" required
               value="<?= htmlspecialchars($autor['apellido']) ?>">

        <label for="nacionalidad">Nacionalidad</label>
        <input type="text" name="nacionalidad" id="nacionalidad"
               value="<?= htmlspecialchars((string)$autor['nacionalidad']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>