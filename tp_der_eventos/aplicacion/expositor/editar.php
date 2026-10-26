<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_expositor = (int)($_POST["id_expositor"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $tema_exposicion = trim($_POST["tema_exposicion"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if ($nombre === "" || $apellido === "") {
        $mensaje = "Debe ingresar un nombre y un apellido.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE expositor SET
                    nombre = :nombre,
                    apellido = :apellido,
                    tema_exposicion = :tema_exposicion,
                    email = :email
                WHERE id_expositor = :id_expositor";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'          => $nombre,
                ':apellido'        => $apellido,
                ':tema_exposicion' => $tema_exposicion,
                ':email'           => $email,
                ':id_expositor'    => $id_expositor
            ]);

            $mensaje = "Expositor modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el expositor.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_expositor"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_expositor, nombre, apellido, tema_exposicion, email
        FROM expositor WHERE id_expositor = :id_expositor";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_expositor' => $id]);
$expositor = $stmt->fetch();

if (!$expositor) {
    die("El expositor solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar expositor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Expositores ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del expositor</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_expositor" value="<?= $expositor['id_expositor'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($expositor['nombre']) ?>">

        <label for="apellido">Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" id="apellido" required
               value="<?= htmlspecialchars($expositor['apellido']) ?>">

        <label for="tema_exposicion">Tema de exposición</label>
        <input type="text" name="tema_exposicion" id="tema_exposicion"
               value="<?= htmlspecialchars((string)$expositor['tema_exposicion']) ?>">

        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars((string)$expositor['email']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>