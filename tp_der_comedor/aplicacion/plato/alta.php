<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $tipo = trim($_POST["tipo"] ?? "");

    if ($nombre === "") {
        $mensaje = "Debe ingresar el nombre del plato.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO plato (nombre, descripcion, tipo)
                VALUES (:nombre, :descripcion, :tipo)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'      => $nombre,
                ':descripcion' => $descripcion,
                ':tipo'        => $tipo
            ]);

            $mensaje = "Plato registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el plato.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar plato</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE COMEDOR UNIVERSITARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Platos ]</a>
        <a href="alta.php">[ Nuevo plato ]</a>
        <a href="../menu/listar.php">[ Menús ]</a>
        <a href="../reserva/listar.php">[ Reservas ]</a>
    </nav>
</header>

<main>

    <h2>Registrar plato</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>

        <label for="tipo">Tipo</label>
        <select name="tipo" id="tipo">
            <option value="">Seleccione un tipo</option>
            <option value="Entrada" <?= ($_POST['tipo'] ?? '') === 'Entrada' ? 'selected' : '' ?>>Entrada</option>
            <option value="Principal" <?= ($_POST['tipo'] ?? '') === 'Principal' ? 'selected' : '' ?>>Principal</option>
            <option value="Postre" <?= ($_POST['tipo'] ?? '') === 'Postre' ? 'selected' : '' ?>>Postre</option>
        </select>

        <button type="submit">Registrar plato</button>

    </form>

    <p><a href="listar.php">Volver al listado de platos</a></p>

</main>

</body>
</html>