<?php
require_once "../conexion.php";

$mensaje = "";
$error   = "";
$est = null;

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {
    $sql = "SELECT * FROM estudiante WHERE id_estudiante = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $_GET["id"]]);
    $est = $stmt->fetch();
    if (!$est) $error = "El estudiante solicitado no existe.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id        = $_POST["id_estudiante"] ?? "";
    $nombre    = trim($_POST["nombre"] ?? "");
    $apellido  = trim($_POST["apellido"] ?? "");
    $dni       = trim($_POST["dni"] ?? "");
    $edad      = trim($_POST["edad"] ?? "");
    $telefono  = trim($_POST["telefono"] ?? "");

    if (!ctype_digit($id)) {
        $error = "Identificador inválido.";
    } elseif ($nombre === "" || $apellido === "" || $dni === "") {
        $error = "Debe ingresar nombre, apellido y DNI.";
    } elseif (!ctype_digit($dni)) {
        $error = "El DNI debe contener solo números.";
    } else {

        $edad = ($edad === "" || !ctype_digit($edad)) ? null : (int)$edad;

        try {

            $sql = "UPDATE estudiante
                    SET nombre = :nombre, apellido = :apellido,
                        dni = :dni, edad = :edad, telefono = :telefono
                    WHERE id_estudiante = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":nombre"   => $nombre,
                ":apellido" => $apellido,
                ":dni"      => $dni,
                ":edad"     => $edad,
                ":telefono" => $telefono,
                ":id"       => $id
            ]);

            $mensaje = "Estudiante modificado correctamente.";

            // Recargar datos actualizados
            $stmt2 = $pdo->prepare("SELECT * FROM estudiante WHERE id_estudiante = :id");
            $stmt2->execute([":id" => $id]);
            $est = $stmt2->fetch();

        } catch (PDOException $e) {
            $error = "No se pudo modificar el estudiante.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar estudiante</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>MODIFICAR ESTUDIANTE</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar estudiantes ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje exito"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <?php if ($error !== ""): ?>
        <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($est): ?>
        <h2>Modificar datos del estudiante</h2>
        <form action="editar.php" method="POST">
            <input type="hidden" name="id_estudiante" value="<?= $est['id_estudiante'] ?>">

            <label>Nombre <span class="requerido">*</span></label>
            <input type="text" name="nombre" required value="<?= htmlspecialchars($est['nombre']) ?>">

            <label>Apellido <span class="requerido">*</span></label>
            <input type="text" name="apellido" required value="<?= htmlspecialchars($est['apellido']) ?>">

            <label>DNI <span class="requerido">*</span></label>
            <input type="text" name="dni" required value="<?= htmlspecialchars($est['dni']) ?>">

            <label>Edad</label>
            <input type="number" name="edad" min="1" value="<?= $est['edad'] !== null ? $est['edad'] : '' ?>">

            <label>Teléfono</label>
            <input type="text" name="telefono" value="<?= htmlspecialchars($est['telefono'] ?? '') ?>">

            <button type="submit">Guardar cambios</button>
        </form>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>