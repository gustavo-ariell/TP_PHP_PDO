<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_plato = (int)($_POST["id_plato"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $tipo = trim($_POST["tipo"] ?? "");

    if ($nombre === "") {
        $mensaje = "Debe ingresar el nombre del plato.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE plato SET
                    nombre = :nombre,
                    descripcion = :descripcion,
                    tipo = :tipo
                WHERE id_plato = :id_plato";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'      => $nombre,
                ':descripcion' => $descripcion,
                ':tipo'        => $tipo,
                ':id_plato'    => $id_plato
            ]);

            $mensaje = "Plato modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el plato.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_plato"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_plato, nombre, descripcion, tipo FROM plato WHERE id_plato = :id_plato";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_plato' => $id]);
$plato = $stmt->fetch();

if (!$plato) {
    die("El plato solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar plato</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE COMEDOR UNIVERSITARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Platos ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del plato</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_plato" value="<?= $plato['id_plato'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($plato['nombre']) ?>">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3"><?= htmlspecialchars((string)$plato['descripcion']) ?></textarea>

        <label for="tipo">Tipo</label>
        <select name="tipo" id="tipo">
            <option value="">Seleccione un tipo</option>
            <option value="Entrada" <?= $plato['tipo'] === 'Entrada' ? 'selected' : '' ?>>Entrada</option>
            <option value="Principal" <?= $plato['tipo'] === 'Principal' ? 'selected' : '' ?>>Principal</option>
            <option value="Postre" <?= $plato['tipo'] === 'Postre' ? 'selected' : '' ?>>Postre</option>
        </select>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>