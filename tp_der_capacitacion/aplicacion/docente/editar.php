<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_docente = (int)($_POST["id_docente"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni = trim($_POST["dni"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");

    if ($nombre === "" || $apellido === "" || $dni === "") {
        $mensaje = "Debe ingresar un nombre, un apellido y un DNI.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE docente SET
                    nombre = :nombre,
                    apellido = :apellido,
                    dni = :dni,
                    email = :email,
                    telefono = :telefono
                WHERE id_docente = :id_docente";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'    => $nombre,
                ':apellido'  => $apellido,
                ':dni'       => $dni,
                ':email'     => $email,
                ':telefono'  => $telefono,
                ':id_docente' => $id_docente
            ]);

            $mensaje = "Docente modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el docente. El DNI ya existe.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_docente"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_docente, nombre, apellido, dni, email, telefono
        FROM docente WHERE id_docente = :id_docente";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_docente' => $id]);
$docente = $stmt->fetch();

if (!$docente) {
    die("El docente solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar docente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE CURSOS DE CAPACITACIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Docentes ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del docente</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_docente" value="<?= $docente['id_docente'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($docente['nombre']) ?>">

        <label for="apellido">Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" id="apellido" required
               value="<?= htmlspecialchars($docente['apellido']) ?>">

        <label for="dni">DNI <span class="requerido">*</span></label>
        <input type="text" name="dni" id="dni" required
               value="<?= htmlspecialchars($docente['dni']) ?>">

        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars((string)$docente['email']) ?>">

        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono"
               value="<?= htmlspecialchars((string)$docente['telefono']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>