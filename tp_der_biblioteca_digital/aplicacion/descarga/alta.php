<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_usuario = $_POST["id_usuario"] ?? "";
    $id_libro = $_POST["id_libro"] ?? "";
    $fecha_descarga = $_POST["fecha_descarga"] ?? "";
    $dispositivo = trim($_POST["dispositivo"] ?? "");

    if ($id_usuario === "" || $id_libro === "" || $fecha_descarga === "") {
        $mensaje = "Debe seleccionar un usuario, un libro e ingresar la fecha de descarga.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO descarga (id_usuario, id_libro, fecha_descarga, dispositivo)
                VALUES (:id_usuario, :id_libro, :fecha_descarga, :dispositivo)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_usuario'     => (int)$id_usuario,
                ':id_libro'       => (int)$id_libro,
                ':fecha_descarga' => $fecha_descarga,
                ':dispositivo'    => $dispositivo
            ]);

            $mensaje = "Descarga registrada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar la descarga.";
            $tipo_mensaje = "error";
        }
    }
}

$usuarios = $pdo->query("SELECT id_usuario, nombre, apellido, email FROM usuario ORDER BY apellido")->fetchAll();
$libros = $pdo->query("SELECT id_libro, titulo FROM libro_digital ORDER BY titulo")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar descarga</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Descargas ]</a>
        <a href="alta.php">[ Nueva descarga ]</a>
        <a href="../libro/listar.php">[ Libros ]</a>
        <a href="../usuario/listar.php">[ Usuarios ]</a>
    </nav>
</header>

<main>

    <h2>Registrar descarga</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="id_usuario">Usuario <span class="requerido">*</span></label>
        <select name="id_usuario" id="id_usuario" required>
            <option value="">Seleccione un usuario</option>
            <?php foreach ($usuarios as $usuario) { ?>
                <option value="<?= $usuario['id_usuario'] ?>">
                    <?= htmlspecialchars($usuario['apellido'] . ", " . $usuario['nombre'] . " (" . $usuario['email'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_libro">Libro <span class="requerido">*</span></label>
        <select name="id_libro" id="id_libro" required>
            <option value="">Seleccione un libro</option>
            <?php foreach ($libros as $libro) { ?>
                <option value="<?= $libro['id_libro'] ?>">
                    <?= htmlspecialchars($libro['titulo']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha_descarga">Fecha y hora de descarga <span class="requerido">*</span></label>
        <input type="datetime-local" name="fecha_descarga" id="fecha_descarga" required
               value="<?= htmlspecialchars($_POST['fecha_descarga'] ?? date('Y-m-d\TH:i')) ?>">

        <label for="dispositivo">Dispositivo</label>
        <input type="text" name="dispositivo" id="dispositivo" placeholder="PC Windows, iPhone, Tablet Android..."
               value="<?= htmlspecialchars($_POST['dispositivo'] ?? '') ?>">

        <button type="submit">Registrar descarga</button>

    </form>

    <p><a href="listar.php">Volver al listado de descargas</a></p>

</main>

</body>
</html>