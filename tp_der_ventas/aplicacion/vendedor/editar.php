<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_vendedor = (int)($_POST["id_vendedor"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni = trim($_POST["dni"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");

    if ($nombre === "" || $apellido === "" || $dni === "") {
        $mensaje = "Debe ingresar un nombre, un apellido y un DNI.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE vendedor SET
                    nombre = :nombre,
                    apellido = :apellido,
                    dni = :dni,
                    telefono = :telefono
                WHERE id_vendedor = :id_vendedor";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'      => $nombre,
                ':apellido'    => $apellido,
                ':dni'         => $dni,
                ':telefono'    => $telefono,
                ':id_vendedor' => $id_vendedor
            ]);

            $mensaje = "Vendedor modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el vendedor. El DNI ya existe.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_vendedor"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_vendedor, nombre, apellido, dni, telefono
        FROM vendedor WHERE id_vendedor = :id_vendedor";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_vendedor' => $id]);
$vendedor = $stmt->fetch();

if (!$vendedor) {
    die("El vendedor solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar vendedor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE VENTAS DE LIBRERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Vendedores ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del vendedor</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_vendedor" value="<?= $vendedor['id_vendedor'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($vendedor['nombre']) ?>">

        <label for="apellido">Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" id="apellido" required
               value="<?= htmlspecialchars($vendedor['apellido']) ?>">

        <label for="dni">DNI <span class="requerido">*</span></label>
        <input type="text" name="dni" id="dni" required
               value="<?= htmlspecialchars($vendedor['dni']) ?>">

        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono"
               value="<?= htmlspecialchars((string)$vendedor['telefono']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>