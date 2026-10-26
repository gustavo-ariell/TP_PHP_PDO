<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_menu = (int)($_POST["id_menu"] ?? 0);
    $fecha = $_POST["fecha"] ?? "";
    $descripcion = trim($_POST["descripcion"] ?? "");

    if ($fecha === "") {
        $mensaje = "Debe ingresar la fecha del menú.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE menu SET fecha = :fecha, descripcion = :descripcion
                WHERE id_menu = :id_menu";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':fecha'       => $fecha,
                ':descripcion' => $descripcion,
                ':id_menu'     => $id_menu
            ]);

            $mensaje = "Menú modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el menú.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_menu"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_menu, fecha, descripcion FROM menu WHERE id_menu = :id_menu";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_menu' => $id]);
$menu = $stmt->fetch();

if (!$menu) {
    die("El menú solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar menú</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE COMEDOR UNIVERSITARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Menús ]</a>
    </nav>
</header>

<main>

    <h2>Modificar menú</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_menu" value="<?= $menu['id_menu'] ?>">

        <label for="fecha">Fecha <span class="requerido">*</span></label>
        <input type="date" name="fecha" id="fecha" required
               value="<?= htmlspecialchars($menu['fecha']) ?>">

        <label for="descripcion">Descripción</label>
        <input type="text" name="descripcion" id="descripcion"
               value="<?= htmlspecialchars((string)$menu['descripcion']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>