<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_proveedor = (int)($_POST["id_proveedor"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $contacto = trim($_POST["contacto"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $direccion = trim($_POST["direccion"] ?? "");

    if ($nombre === "") {
        $mensaje = "Debe ingresar el nombre del proveedor.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE proveedor SET
                    nombre = :nombre,
                    contacto = :contacto,
                    telefono = :telefono,
                    email = :email,
                    direccion = :direccion
                WHERE id_proveedor = :id_proveedor";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'       => $nombre,
                ':contacto'     => $contacto,
                ':telefono'     => $telefono,
                ':email'        => $email,
                ':direccion'    => $direccion,
                ':id_proveedor' => $id_proveedor
            ]);

            $mensaje = "Proveedor modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el proveedor.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_proveedor"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_proveedor, nombre, contacto, telefono, email, direccion
        FROM proveedor WHERE id_proveedor = :id_proveedor";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_proveedor' => $id]);
$proveedor = $stmt->fetch();

if (!$proveedor) {
    die("El proveedor solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar proveedor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE INVENTARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Proveedores ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del proveedor</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_proveedor" value="<?= $proveedor['id_proveedor'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($proveedor['nombre']) ?>">

        <label for="contacto">Persona de contacto</label>
        <input type="text" name="contacto" id="contacto"
               value="<?= htmlspecialchars((string)$proveedor['contacto']) ?>">

        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono"
               value="<?= htmlspecialchars((string)$proveedor['telefono']) ?>">

        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars((string)$proveedor['email']) ?>">

        <label for="direccion">Dirección</label>
        <input type="text" name="direccion" id="direccion"
               value="<?= htmlspecialchars((string)$proveedor['direccion']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>