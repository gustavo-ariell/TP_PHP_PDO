<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_estudiante = (int)($_POST["id_estudiante"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni = trim($_POST["dni"] ?? "");
    $curso = trim($_POST["curso"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if ($nombre === "" || $apellido === "" || $dni === "") {

        $mensaje = "Debe ingresar un nombre, un apellido y un DNI.";
        $tipo_mensaje = "error";

    } elseif ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $mensaje = "Debe ingresar un correo electrónico válido.";
        $tipo_mensaje = "error";

    } else {

        $sql = "UPDATE estudiante SET
                    nombre = :nombre,
                    apellido = :apellido,
                    dni = :dni,
                    curso = :curso,
                    telefono = :telefono,
                    email = :email
                WHERE id_estudiante = :id_estudiante";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'        => $nombre,
                ':apellido'      => $apellido,
                ':dni'           => $dni,
                ':curso'         => $curso,
                ':telefono'      => $telefono,
                ':email'         => $email,
                ':id_estudiante' => $id_estudiante
            ]);

            $mensaje = "Estudiante modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el estudiante. El DNI ya existe.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_estudiante"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_estudiante, nombre, apellido, dni, curso, telefono, email
        FROM estudiante
        WHERE id_estudiante = :id_estudiante";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_estudiante' => $id]);
$estudiante = $stmt->fetch();

if (!$estudiante) {
    die("El estudiante solicitado no existe.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar estudiante</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Estudiantes ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del estudiante</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_estudiante" value="<?= $estudiante['id_estudiante'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($estudiante['nombre']) ?>">

        <label for="apellido">Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" id="apellido" required
               value="<?= htmlspecialchars($estudiante['apellido']) ?>">

        <label for="dni">DNI <span class="requerido">*</span></label>
        <input type="text" name="dni" id="dni" required
               value="<?= htmlspecialchars($estudiante['dni']) ?>">

        <label for="curso">Curso</label>
        <input type="text" name="curso" id="curso"
               value="<?= htmlspecialchars((string)$estudiante['curso']) ?>">

        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono"
               value="<?= htmlspecialchars((string)$estudiante['telefono']) ?>">

        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars((string)$estudiante['email']) ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>