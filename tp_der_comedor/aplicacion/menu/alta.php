<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fecha = $_POST["fecha"] ?? "";
    $descripcion = trim($_POST["descripcion"] ?? "");

    if ($fecha === "") {
        $mensaje = "Debe ingresar la fecha del menú.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO menu (fecha, descripcion) VALUES (:fecha, :descripcion)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':fecha'       => $fecha,
                ':descripcion' => $descripcion
            ]);

            $id_menu = $pdo->lastInsertId();

            header("Location: asociar.php?id=" . $id_menu);
            exit;

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el menú.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar menú</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE COMEDOR UNIVERSITARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Menús ]</a>
        <a href="alta.php">[ Nuevo menú ]</a>
        <a href="../plato/listar.php">[ Platos ]</a>
        <a href="../reserva/listar.php">[ Reservas ]</a>
    </nav>
</header>

<main>

    <h2>Registrar menú</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="fecha">Fecha <span class="requerido">*</span></label>
        <input type="date" name="fecha" id="fecha" required
               value="<?= htmlspecialchars($_POST['fecha'] ?? date('Y-m-d')) ?>">

        <label for="descripcion">Descripción</label>
        <input type="text" name="descripcion" id="descripcion"
               value="<?= htmlspecialchars($_POST['descripcion'] ?? '') ?>">

        <button type="submit">Registrar menú y asociar platos</button>

    </form>

    <p><a href="listar.php">Volver al listado de menús</a></p>

</main>

</body>
</html>