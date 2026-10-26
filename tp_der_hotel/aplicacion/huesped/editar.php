<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_huesped = (int)($_POST["id_huesped"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni = trim($_POST["dni"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if ($nombre === "" || $apellido === "" || $dni === "") {
        $mensaje = "Debe ingresar un nombre, un apellido y un DNI.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE huesped SET
                    nombre = :nombre,
                    apellido = :apellido,
                    dni = :dni,
                    telefono = :telefono,
                    email = :email
                WHERE id_huesped = :id_huesped";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'   => $nombre,
                ':apellido' => $apellido,
                ':dni'      => $dni,
                ':telefono' => $telefono,
                ':email'    => $email,
                ':id_huesped' => $id_huesped
            ]);

            $mensaje = "Huésped modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el huésped. El DNI ya existe.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_huesped"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_huesped, nombre, apellido, dni, telefono, email
        FROM huesped WHERE id_huesped = :id_huesped";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_huesped' => $id]);
$huesped = $stmt->fetch();

if (!$huesped) {
    die("El huésped solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar huésped</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Huéspedes ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del huésped</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_huesped" value="<?= $huesped['id_huesped'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($huesped['nombre']) ?>">

        <label for="apellido">Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" id="apellido" required
               value="<?= htmlspecialchars($huesped['apellido']) ?>">

        <label for="dni">DNI <span class="requerido">*</span></label>
        <input type="text" name="dni" id="dni" required
               value="<?= htmlspecialchars($huesped['dni']) ?>">

        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono"
               value="<?= htmlspecialchars((string)$huesped['telefono']) ?>">

        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars((string)$huesped['email']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>