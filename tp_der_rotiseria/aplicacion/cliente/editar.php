<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_cliente = (int)($_POST["id_cliente"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni = trim($_POST["dni"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $direccion = trim($_POST["direccion"] ?? "");

    if ($nombre === "" || $apellido === "" || $dni === "") {
        $mensaje = "Debe ingresar un nombre, un apellido y un DNI.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE cliente SET
                    nombre = :nombre,
                    apellido = :apellido,
                    dni = :dni,
                    telefono = :telefono,
                    direccion = :direccion
                WHERE id_cliente = :id_cliente";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'     => $nombre,
                ':apellido'   => $apellido,
                ':dni'        => $dni,
                ':telefono'   => $telefono,
                ':direccion'  => $direccion,
                ':id_cliente' => $id_cliente
            ]);

            $mensaje = "Cliente modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el cliente. El DNI ya existe.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_cliente"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_cliente, nombre, apellido, dni, telefono, direccion
        FROM cliente WHERE id_cliente = :id_cliente";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_cliente' => $id]);
$cliente = $stmt->fetch();

if (!$cliente) {
    die("El cliente solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar cliente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE PEDIDOS — ROTISERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Clientes ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del cliente</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($cliente['nombre']) ?>">

        <label for="apellido">Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" id="apellido" required
               value="<?= htmlspecialchars($cliente['apellido']) ?>">

        <label for="dni">DNI <span class="requerido">*</span></label>
        <input type="text" name="dni" id="dni" required
               value="<?= htmlspecialchars($cliente['dni']) ?>">

        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono"
               value="<?= htmlspecialchars((string)$cliente['telefono']) ?>">

        <label for="direccion">Dirección</label>
        <input type="text" name="direccion" id="direccion"
               value="<?= htmlspecialchars((string)$cliente['direccion']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>