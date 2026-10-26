<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$autor = null;

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {
    $stmt = $pdo->prepare("SELECT * FROM autor WHERE id_autor = :id");
    $stmt->execute([':id' => (int)$_GET["id"]]);
    $autor = $stmt->fetch();
    if (!$autor) {
        $mensaje = "El autor solicitado no existe.";
        $tipo_mensaje = "error";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id          = $_POST["id_autor"] ?? "";
    $nombre      = trim($_POST["nombre"] ?? "");
    $apellido    = trim($_POST["apellido"] ?? "");
    $email       = trim($_POST["email"] ?? "");
    $institucion = trim($_POST["institucion"] ?? "");

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

            $stmt = $pdo->prepare("UPDATE autor
                                   SET nombre = :nombre, apellido = :apellido,
                                       email = :email, institucion = :institucion
                                   WHERE id_autor = :id");
            $stmt->execute([
                ':nombre'      => $nombre,
                ':apellido'    => $apellido,
                ':email'       => $email,
                ':institucion' => $institucion,
                ':id'          => (int)$id
            ]);

            $mensaje = "Autor modificado correctamente.";
            $tipo_mensaje = "exito";

            $stmt2 = $pdo->prepare("SELECT * FROM autor WHERE id_autor = :id");
            $stmt2->execute([':id' => (int)$id]);
            $autor = $stmt2->fetch();

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el autor.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar autor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>MODIFICAR AUTOR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar autores ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <?php if ($autor): ?>

        <h2>Modificar datos del autor</h2>

        <form action="editar.php" method="POST">

            <input type="hidden" name="id_autor" value="<?= $autor['id_autor'] ?>">

            <label>Nombre <span class="requerido">*</span></label>
            <input type="text" name="nombre" required
                   value="<?= htmlspecialchars($autor['nombre']) ?>">

            <label>Apellido <span class="requerido">*</span></label>
            <input type="text" name="apellido" required
                   value="<?= htmlspecialchars($autor['apellido']) ?>">

            <label>Email</label>
            <input type="email" name="email"
                   value="<?= htmlspecialchars($autor['email'] ?? '') ?>">

            <label>Institución</label>
            <input type="text" name="institucion"
                   value="<?= htmlspecialchars($autor['institucion'] ?? '') ?>">

            <button type="submit">Guardar cambios</button>

        </form>

    <?php else: ?>
        <div class="mensaje error">
            No se pudo cargar el autor. <a href="listar.php">Volver al listado</a>
        </div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>