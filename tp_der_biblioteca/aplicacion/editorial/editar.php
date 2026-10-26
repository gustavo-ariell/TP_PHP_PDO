<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_editorial = (int)($_POST["id_editorial"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $direccion = trim($_POST["direccion"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");

    if ($nombre === "") {

        $mensaje = "Debe ingresar el nombre de la editorial.";
        $tipo_mensaje = "error";

    } else {

        $sql = "UPDATE editorial SET
                    nombre = :nombre,
                    direccion = :direccion,
                    telefono = :telefono
                WHERE id_editorial = :id_editorial";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'       => $nombre,
                ':direccion'    => $direccion,
                ':telefono'     => $telefono,
                ':id_editorial' => $id_editorial
            ]);

            $mensaje = "Editorial modificada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar la editorial.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_editorial"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_editorial, nombre, direccion, telefono
        FROM editorial
        WHERE id_editorial = :id_editorial";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_editorial' => $id]);
$editorial = $stmt->fetch();

if (!$editorial) {
    die("La editorial solicitada no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar editorial</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Editoriales ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información de la editorial</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_editorial" value="<?= $editorial['id_editorial'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($editorial['nombre']) ?>">

        <label for="direccion">Dirección</label>
        <input type="text" name="direccion" id="direccion"
               value="<?= htmlspecialchars((string)$editorial['direccion']) ?>">

        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono"
               value="<?= htmlspecialchars((string)$editorial['telefono']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>