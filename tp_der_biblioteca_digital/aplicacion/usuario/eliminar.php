<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_usuario"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        $stmt_desc = $pdo->prepare("DELETE FROM descarga WHERE id_usuario = :id_usuario");
        $stmt_desc->execute([':id_usuario' => $id]);

        $stmt = $pdo->prepare("DELETE FROM usuario WHERE id_usuario = :id_usuario");
        $stmt->execute([':id_usuario' => $id]);

        $mensaje = "Usuario eliminado correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar el usuario.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT nombre, apellido FROM usuario WHERE id_usuario = :id_usuario";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_usuario' => $id]);
$usuario = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar usuario</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Usuarios ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar usuario</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($usuario && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar al usuario
           <strong><?= htmlspecialchars($usuario['nombre'] . " " . $usuario['apellido']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_usuario" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de usuarios</a></p>

    <?php } ?>

</main>

</body>
</html>