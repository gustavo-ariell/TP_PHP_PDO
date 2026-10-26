<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $duracion = trim($_POST["duracion"] ?? "");
    $modalidad = trim($_POST["modalidad"] ?? "");
    $id_docente = $_POST["id_docente"] ?? "";

    if ($nombre === "" || $id_docente === "") {
        $mensaje = "Debe ingresar un nombre y seleccionar un docente.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO curso (nombre, descripcion, duracion, modalidad, id_docente)
                VALUES (:nombre, :descripcion, :duracion, :modalidad, :id_docente)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'      => $nombre,
                ':descripcion' => $descripcion,
                ':duracion'    => $duracion,
                ':modalidad'   => $modalidad,
                ':id_docente'  => (int)$id_docente
            ]);

            $mensaje = "Curso registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el curso.";
            $tipo_mensaje = "error";
        }
    }
}

$docentes = $pdo->query("SELECT id_docente, nombre, apellido FROM docente ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar curso</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE CURSOS DE CAPACITACIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Cursos ]</a>
        <a href="alta.php">[ Nuevo curso ]</a>
        <a href="../docente/listar.php">[ Docentes ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
        <a href="../inscripcion/listar.php">[ Inscripciones ]</a>
    </nav>
</header>

<main>

    <h2>Registrar curso</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>

        <label for="duracion">Duración</label>
        <input type="text" name="duracion" id="duracion"
               value="<?= htmlspecialchars($_POST['duracion'] ?? '') ?>">

        <label for="modalidad">Modalidad</label>
        <select name="modalidad" id="modalidad">
            <option value="">Seleccione una modalidad</option>
            <option value="Presencial" <?= ($_POST['modalidad'] ?? '') === 'Presencial' ? 'selected' : '' ?>>Presencial</option>
            <option value="Virtual" <?= ($_POST['modalidad'] ?? '') === 'Virtual' ? 'selected' : '' ?>>Virtual</option>
        </select>

        <label for="id_docente">Docente <span class="requerido">*</span></label>
        <select name="id_docente" id="id_docente" required>
            <option value="">Seleccione un docente</option>
            <?php foreach ($docentes as $docente) { ?>
                <option value="<?= $docente['id_docente'] ?>">
                    <?= htmlspecialchars($docente['apellido'] . ", " . $docente['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Registrar curso</button>

    </form>

    <p><a href="listar.php">Volver al listado de cursos</a></p>

</main>

</body>
</html>