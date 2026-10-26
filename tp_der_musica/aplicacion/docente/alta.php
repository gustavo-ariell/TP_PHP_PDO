<?php
require_once "../conexion.php";

$mensaje = "";
$error   = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre          = trim($_POST["nombre"] ?? "");
    $apellido        = trim($_POST["apellido"] ?? "");
    $id_instrumento  = $_POST["id_instrumento"] ?? "";
    $email           = trim($_POST["email"] ?? "");

    if ($nombre === "" || $apellido === "") {
        $error = "Debe ingresar nombre y apellido.";
    } elseif (!ctype_digit($id_instrumento)) {
        $error = "Debe seleccionar un instrumento.";
    } elseif ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El correo electrónico no tiene un formato válido.";
    } else {

        try {

            $sql = "INSERT INTO docente (nombre, apellido, id_instrumento, email)
                    VALUES (:nombre, :apellido, :id_instrumento, :email)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":nombre"         => $nombre,
                ":apellido"       => $apellido,
                ":id_instrumento" => $id_instrumento,
                ":email"          => $email
            ]);

            $mensaje = "Docente registrado correctamente.";

        } catch (PDOException $e) {
            $error = "No se pudo registrar el docente.";
        }
    }
}

$instrumentos = $pdo->query("SELECT id_instrumento, nombre FROM instrumento ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar docente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>REGISTRAR DOCENTE</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar docentes ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje exito"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <?php if ($error !== ""): ?>
        <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <h2>Nuevo docente</h2>

    <form action="alta.php" method="POST">
        <label>Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" required>

        <label>Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" required>

        <label>Instrumento <span class="requerido">*</span></label>
        <select name="id_instrumento" required>
            <option value="">-- Seleccione un instrumento --</option>
            <?php foreach ($instrumentos as $inst): ?>
                <option value="<?= $inst['id_instrumento'] ?>">
                    <?= htmlspecialchars($inst['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Email</label>
        <input type="email" name="email">

        <button type="submit">Registrar</button>
    </form>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>