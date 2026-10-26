<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_curso = (int)($_POST["id_curso"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $duracion = trim($_POST["duracion"] ?? "");
    $modalidad = trim($_POST["modalidad"] ?? "");
    $id_docente = $_POST["id_docente"] ?? "";

    if ($nombre === "" || $id_docente === "") {
        $mensaje = "Debe ingresar un nombre y seleccionar un docente.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE curso SET
                    nombre = :nombre,
                    descripcion = :descripcion,
                    duracion = :duracion,
                    modalidad = :modalidad,
                    id_docente = :id_docente
                WHERE id_curso = :id_curso";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'      => $nombre,
                ':descripcion' => $descripcion,
                ':duracion'    => $duracion,
                ':modalidad'   => $modalidad,
                ':id_docente'  => (int)$id_docente,
                ':id_curso'    => $id_curso
            ]);

            $mensaje = "Curso modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el curso.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_curso"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_curso, nombre, descripcion, duracion, modalidad, id_docente
        FROM curso WHERE id_curso = :id_curso";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_curso' => $id]);
$curso = $stmt->fetch();

if (!$curso) {
    die("El curso solicitado no existe.");
}

$docentes = $pdo->query("SELECT id_docente, nombre, apellido FROM docente ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar curso</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE CURSOS DE CAPACITACIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Cursos ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del curso</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_curso" value="<?= $curso['id_curso'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($curso['nombre']) ?>">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3"><?= htmlspecialchars((string)$curso['descripcion']) ?></textarea>

        <label for="duracion">Duración</label>
        <input type="text" name="duracion" id="duracion"
               value="<?= htmlspecialchars((string)$curso['duracion']) ?>">

        <label for="modalidad">Modalidad</label>
        <select name="modalidad" id="modalidad">
            <option value="">Seleccione una modalidad</option>
            <option value="Presencial" <?= $curso['modalidad'] === 'Presencial' ? 'selected' : '' ?>>Presencial</option>
            <option value="Virtual" <?= $curso['modalidad'] === 'Virtual' ? 'selected' : '' ?>>Virtual</option>
        </select>

        <label for="id_docente">Docente <span class="requerido">*</span></label>
        <select name="id_docente" id="id_docente" required>
            <?php foreach ($docentes as $docente) { ?>
                <option value="<?= $docente['id_docente'] ?>"
                    <?= $docente['id_docente'] == $curso['id_docente'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($docente['apellido'] . ", " . $docente['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>