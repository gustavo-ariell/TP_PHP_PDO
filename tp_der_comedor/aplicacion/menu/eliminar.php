<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_menu"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        $stmt_mp = $pdo->prepare("DELETE FROM menu_plato WHERE id_menu = :id_menu");
        $stmt_mp->execute([':id_menu' => $id]);

        $stmt_res = $pdo->prepare("DELETE FROM reserva WHERE id_menu = :id_menu");
        $stmt_res->execute([':id_menu' => $id]);

        $stmt_menu = $pdo->prepare("DELETE FROM menu WHERE id_menu = :id_menu");
        $stmt_menu->execute([':id_menu' => $id]);

        $mensaje = "Menú eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el menú.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT fecha, descripcion FROM menu WHERE id_menu = :id_menu";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_menu' => $id]);
$menu = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar menú</title>
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

    <h2>Eliminar menú</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($menu && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar el menú del día
           <strong><?= htmlspecialchars($menu['fecha']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_menu" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de menús</a></p>

    <?php } ?>

</main>

</body>
</html>