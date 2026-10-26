<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$eval = null;

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {
    $stmt = $pdo->prepare("SELECT * FROM evaluador WHERE id_evaluador = :id");
    $stmt->execute([':id' => (int)$_GET["id"]]);
    $eval = $stmt->fetch();
    if (!$eval) {
        $mensaje = "El evaluador solicitado no existe.";
        $tipo_mensaje = "error";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id           = $_POST["id_evaluador"] ?? "";
    $nombre       = trim($_POST["nombre"] ?? "");
    $apellido     = trim($_POST["apellido"] ?? "");
    $email        = trim($_POST["email"] ?? "");
    $especialidad = trim($_POST["especialidad"] ?? "");

    if (!ctype_digit($id)) {
        $mensaje = "Identificador inválido.";
        $tipo_mensaje = "error";
    } elseif ($nombre === "" || $apellido === "") {
        $mensaje = "Debe ingresar nombre y apellido.";
        $tipo_mensaje = "error";
    } elseif ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo electrónico no tiene un formato válido.";
        $tipo_mensaje = "error";
    } else {

        try {

            $stmt = $pdo->prepare("UPDATE evaluador
                                   SET nombre = :nombre, apellido = :apellido,
                                       email = :email, especialidad = :especialidad
                                   WHERE id_evaluador = :id");
            $stmt->execute([
                ':nombre'       => $nombre,
                ':apellido'     => $apellido,
                ':email'        => $email,
                ':especialidad' => $especialidad,
                ':id'           => (int)$id
            ]);

            $mensaje = "Evaluador modificado correctamente.";
            $tipo_mensaje = "exito";

            $stmt2 = $pdo->prepare("SELECT * FROM evaluador WHERE id_evaluador = :id");
            $stmt2->execute([':id' => (int)$id]);
            $eval = $stmt2->fetch();

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el evaluador.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar evaluador</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>MODIFICAR EVALUADOR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar evaluadores ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <?php if ($eval): ?>

        <h2>Modificar datos del evaluador</h2>

        <form action="editar.php" method="POST">

            <input type="hidden" name="id_evaluador" value="<?= $eval['id_evaluador'] ?>">

            <label>Nombre <span class="requerido">*</span></label>
            <input type="text" name="nombre" required
                   value="<?= htmlspecialchars($eval['nombre']) ?>">

            <label>Apellido <span class="requerido">*</span></label>
            <input type="text" name="apellido" required
                   value="<?= htmlspecialchars($eval['apellido']) ?>">

            <label>Email</label>
            <input type="email" name="email"
                   value="<?= htmlspecialchars($eval['email'] ?? '') ?>">

            <label>Especialidad</label>
            <input type="text" name="especialidad"
                   value="<?= htmlspecialchars($eval['especialidad'] ?? '') ?>">

            <button type="submit">Guardar cambios</button>

        </form>

    <?php else: ?>
        <div class="mensaje error">
            No se pudo cargar el evaluador. <a href="listar.php">Volver al listado</a>
        </div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>