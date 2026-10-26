<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_estudiante = (int)($_POST["id_estudiante"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni = trim($_POST["dni"] ?? "");
    $direccion = trim($_POST["direccion"] ?? "");
    $id_curso = $_POST["id_curso"] ?? "";
    $id_division = $_POST["id_division"] ?? "";
    $id_localidad = $_POST["id_localidad"] ?? "";
    $id_provincia = $_POST["id_provincia"] ?? "";
    $id_pais = $_POST["id_pais"] ?? "";

    if ($nombre === "" || $apellido === "" || $dni === "") {
        $mensaje = "Debe ingresar un nombre, un apellido y un DNI.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE estudiante SET
                    nombre = :nombre,
                    apellido = :apellido,
                    dni = :dni,
                    direccion = :direccion,
                    id_curso = :id_curso,
                    id_division = :id_division,
                    id_localidad = :id_localidad,
                    id_provincia = :id_provincia,
                    id_pais = :id_pais
                WHERE id_estudiante = :id_estudiante";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'        => $nombre,
                ':apellido'      => $apellido,
                ':dni'           => $dni,
                ':direccion'     => $direccion,
                ':id_curso'      => ($id_curso === "" ? null : (int)$id_curso),
                ':id_division'   => ($id_division === "" ? null : (int)$id_division),
                ':id_localidad'  => ($id_localidad === "" ? null : (int)$id_localidad),
                ':id_provincia'  => ($id_provincia === "" ? null : (int)$id_provincia),
                ':id_pais'       => ($id_pais === "" ? null : (int)$id_pais),
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

$sql = "SELECT id_estudiante, nombre, apellido, dni, direccion,
               id_curso, id_division, id_localidad, id_provincia, id_pais
        FROM estudiante
        WHERE id_estudiante = :id_estudiante";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_estudiante' => $id]);
$estudiante = $stmt->fetch();

if (!$estudiante) {
    die("El estudiante solicitado no existe.");
}

$cursos = $pdo->query("SELECT id_curso, nombre FROM curso ORDER BY nombre")->fetchAll();
$divisiones = $pdo->query("SELECT id_division, nombre FROM division ORDER BY nombre")->fetchAll();
$localidades = $pdo->query("SELECT id_localidad, nombre FROM localidad ORDER BY nombre")->fetchAll();
$provincias = $pdo->query("SELECT id_provincia, nombre FROM provincia ORDER BY nombre")->fetchAll();
$paises = $pdo->query("SELECT id_pais, nombre FROM pais ORDER BY nombre")->fetchAll();
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
    <h1>SISTEMA DE INSCRIPCIÓN A OLIMPIADAS ESCOLARES</h1>
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

        <label for="direccion">Dirección</label>
        <input type="text" name="direccion" id="direccion"
               value="<?= htmlspecialchars((string)$estudiante['direccion']) ?>">

        <label for="id_curso">Curso</label>
        <select name="id_curso" id="id_curso">
            <option value="">Seleccione un curso</option>
            <?php foreach ($cursos as $curso) { ?>
                <option value="<?= $curso['id_curso'] ?>"
                    <?= $curso['id_curso'] == $estudiante['id_curso'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($curso['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_division">División</label>
        <select name="id_division" id="id_division">
            <option value="">Seleccione una división</option>
            <?php foreach ($divisiones as $division) { ?>
                <option value="<?= $division['id_division'] ?>"
                    <?= $division['id_division'] == $estudiante['id_division'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($division['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_pais">País</label>
        <select name="id_pais" id="id_pais">
            <option value="">Seleccione un país</option>
            <?php foreach ($paises as $pais) { ?>
                <option value="<?= $pais['id_pais'] ?>"
                    <?= $pais['id_pais'] == $estudiante['id_pais'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($pais['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_provincia">Provincia</label>
        <select name="id_provincia" id="id_provincia">
            <option value="">Seleccione una provincia</option>
            <?php foreach ($provincias as $provincia) { ?>
                <option value="<?= $provincia['id_provincia'] ?>"
                    <?= $provincia['id_provincia'] == $estudiante['id_provincia'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($provincia['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_localidad">Localidad</label>
        <select name="id_localidad" id="id_localidad">
            <option value="">Seleccione una localidad</option>
            <?php foreach ($localidades as $localidad) { ?>
                <option value="<?= $localidad['id_localidad'] ?>"
                    <?= $localidad['id_localidad'] == $estudiante['id_localidad'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($localidad['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>