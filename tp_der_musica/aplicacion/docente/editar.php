<?php
require_once "../conexion.php";

$mensaje = "";
$error   = "";
$doc = null;

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {
    $stmt = $pdo->prepare("SELECT * FROM docente WHERE id_docente = :id");
    $stmt->execute([":id" => $_GET["id"]]);
    $doc = $stmt->fetch();
    if (!$doc) $error = "El docente solicitado no existe.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id             = $_POST["id_docente"] ?? "";
    $nombre         = trim($_POST["nombre"] ?? "");
    $apellido       = trim($_POST["apellido"] ?? "");
    $id_instrumento = $_POST["id_instrumento"] ?? "";
    $email          = trim($_POST["email"] ?? "");

    if (!ctype_digit($id)) {
        $error = "Identificador inválido.";
    } elseif ($nombre === "" || $apellido === "") {
        $error = "Debe ingresar nombre y apellido.";
    } elseif (!ctype_digit($id_instrumento)) {
        $error = "Debe seleccionar un instrumento.";
    } elseif ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El correo electrónico no tiene un formato válido.";
    } else {

        try {

            $sql = "UPDATE docente
                    SET nombre = :nombre, apellido = :apellido,
                        id_instrumento = :id_instrumento, email = :email
                    WHERE id_docente = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":nombre"         => $nombre,
                ":apellido"       => $apellido,
                ":id_instrumento" => $id_instrumento,
                ":email"          => $email,
                ":id"             => $id
            ]);

            $mensaje = "Docente modificado correctamente.";

            $stmt2 = $pdo->prepare("SELECT * FROM docente WHERE id_docente = :id");
            $stmt2->execute([":id" => $id]);
            $doc = $stmt2->fetch();

        } catch (PDOException $e) {
            $error = "No se pudo modificar el docente.";
        }
    }
}

$instrumentos = $pdo->query("SELECT id_instrumento, nombre FROM instrumento ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar docente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>MODIFICAR DOCENTE</h1>
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

    <?php if ($doc): ?>
        <h2>Modificar datos del docente</h2>
        <form action="editar.php" method="POST">
            <input type="hidden" name="id_docente" value="<?= $doc['id_docente'] ?>">

            <label>Nombre <span class="requerido">*</span></label>
            <input type="text" name="nombre" required value="<?= htmlspecialchars($doc['nombre']) ?>">

            <label>Apellido <span class="requerido">*</span></label>
            <input type="text" name="apellido" required value="<?= htmlspecialchars($doc['apellido']) ?>">

            <label>Instrumento <span class="requerido">*</span></label>
            <select name="id_instrumento" required>
                <?php foreach ($instrumentos as $inst): ?>
                    <option value="<?= $inst['id_instrumento'] ?>"
                        <?= ($inst['id_instrumento'] == $doc['id_instrumento']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($inst['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($doc['email'] ?? '') ?>">

            <button type="submit">Guardar cambios</button>
        </form>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>