<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$persona = null;

// Cargar datos si viene por GET
if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {
    $stmt = $pdo->prepare("SELECT * FROM persona WHERE id_persona = :id");
    $stmt->execute([':id' => (int)$_GET["id"]]);
    $persona = $stmt->fetch();
    if (!$persona) {
        $mensaje = "La persona solicitada no existe.";
        $tipo_mensaje = "error";
    }
}

// Procesar modificación si viene por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id            = $_POST["id_persona"] ?? "";
    $nombre        = trim($_POST["nombre"] ?? "");
    $apellido      = trim($_POST["apellido"] ?? "");
    $dni           = trim($_POST["dni"] ?? "");
    $tipo_persona  = $_POST["tipo_persona"] ?? "";
    $telefono      = trim($_POST["telefono"] ?? "");
    $email         = trim($_POST["email"] ?? "");

    $tiposValidos = ["docente", "estudiante", "personal_administrativo"];

    if (!ctype_digit($id)) {
        $mensaje = "Identificador inválido.";
        $tipo_mensaje = "error";
    } elseif ($nombre === "" || $apellido === "" || $dni === "") {
        $mensaje = "Debe ingresar nombre, apellido y DNI.";
        $tipo_mensaje = "error";
    } elseif (!ctype_digit($dni)) {
        $mensaje = "El DNI debe contener solo números.";
        $tipo_mensaje = "error";
    } elseif (!in_array($tipo_persona, $tiposValidos)) {
        $mensaje = "Debe seleccionar un tipo de persona válido.";
        $tipo_mensaje = "error";
    } elseif ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo electrónico no tiene un formato válido.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE persona
                SET nombre = :nombre,
                    apellido = :apellido,
                    dni = :dni,
                    tipo_persona = :tipo_persona,
                    telefono = :telefono,
                    email = :email
                WHERE id_persona = :id";

        try {

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nombre'       => $nombre,
                ':apellido'     => $apellido,
                ':dni'          => $dni,
                ':tipo_persona' => $tipo_persona,
                ':telefono'     => $telefono,
                ':email'        => $email,
                ':id'           => (int)$id
            ]);

            $mensaje = "Persona modificada correctamente.";
            $tipo_mensaje = "exito";

            // Recargar datos actualizados
            $stmt2 = $pdo->prepare("SELECT * FROM persona WHERE id_persona = :id");
            $stmt2->execute([':id' => (int)$id]);
            $persona = $stmt2->fetch();

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar la persona. Verifique que el DNI no esté repetido.";
            $tipo_mensaje = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar persona</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>MODIFICAR PERSONA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar personas ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <?php if ($persona): ?>

        <h2>Modificar datos de la persona</h2>

        <form action="editar.php" method="POST">

            <input type="hidden" name="id_persona" value="<?= $persona['id_persona'] ?>">

            <label>Nombre <span class="requerido">*</span></label>
            <input type="text" name="nombre" required
                   value="<?= htmlspecialchars($persona['nombre']) ?>">

            <label>Apellido <span class="requerido">*</span></label>
            <input type="text" name="apellido" required
                   value="<?= htmlspecialchars($persona['apellido']) ?>">

            <label>DNI <span class="requerido">*</span></label>
            <input type="text" name="dni" required
                   value="<?= htmlspecialchars($persona['dni']) ?>">

            <label>Tipo de persona <span class="requerido">*</span></label>
            <select name="tipo_persona" required>
                <option value="docente" <?= $persona['tipo_persona'] === 'docente' ? 'selected' : '' ?>>
                    Docente
                </option>
                <option value="estudiante" <?= $persona['tipo_persona'] === 'estudiante' ? 'selected' : '' ?>>
                    Estudiante
                </option>
                <option value="personal_administrativo" <?= $persona['tipo_persona'] === 'personal_administrativo' ? 'selected' : '' ?>>
                    Personal administrativo
                </option>
            </select>

            <label>Teléfono</label>
            <input type="text" name="telefono"
                   value="<?= htmlspecialchars($persona['telefono'] ?? '') ?>">

            <label>Email</label>
            <input type="email" name="email"
                   value="<?= htmlspecialchars($persona['email'] ?? '') ?>">

            <button type="submit">Guardar cambios</button>

        </form>

    <?php else: ?>

        <div class="mensaje error">
            No se pudo cargar la persona. <a href="listar.php">Volver al listado</a>
        </div>

    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Préstamos de Herramientas</p>
</footer>

</body>
</html>