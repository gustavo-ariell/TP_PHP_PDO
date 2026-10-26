<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_medico = (int)($_POST["id_medico"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $matricula = trim($_POST["matricula"] ?? "");
    $id_especialidad = $_POST["id_especialidad"] ?? "";

    if ($nombre === "" || $apellido === "" || $matricula === "" || $id_especialidad === "") {
        $mensaje = "Debe completar todos los campos obligatorios.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE medico SET
                    nombre = :nombre,
                    apellido = :apellido,
                    matricula = :matricula,
                    id_especialidad = :id_especialidad
                WHERE id_medico = :id_medico";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'          => $nombre,
                ':apellido'        => $apellido,
                ':matricula'       => $matricula,
                ':id_especialidad' => (int)$id_especialidad,
                ':id_medico'       => $id_medico
            ]);

            $mensaje = "Médico modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el médico. La matrícula ya existe.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_medico"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_medico, nombre, apellido, matricula, id_especialidad
        FROM medico WHERE id_medico = :id_medico";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_medico' => $id]);
$medico = $stmt->fetch();

if (!$medico) {
    die("El médico solicitado no existe.");
}

$especialidades = $pdo->query("SELECT id_especialidad, nombre FROM especialidad ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar médico</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TURNOS CLÍNICA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Médicos ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del médico</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_medico" value="<?= $medico['id_medico'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($medico['nombre']) ?>">

        <label for="apellido">Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" id="apellido" required
               value="<?= htmlspecialchars($medico['apellido']) ?>">

        <label for="matricula">Matrícula <span class="requerido">*</span></label>
        <input type="text" name="matricula" id="matricula" required
               value="<?= htmlspecialchars($medico['matricula']) ?>">

        <label for="id_especialidad">Especialidad <span class="requerido">*</span></label>
        <select name="id_especialidad" id="id_especialidad" required>
            <?php foreach ($especialidades as $especialidad) { ?>
                <option value="<?= $especialidad['id_especialidad'] ?>"
                    <?= $especialidad['id_especialidad'] == $medico['id_especialidad'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($especialidad['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>