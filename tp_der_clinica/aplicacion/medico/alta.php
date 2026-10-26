<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $matricula = trim($_POST["matricula"] ?? "");
    $id_especialidad = $_POST["id_especialidad"] ?? "";

    if ($nombre === "" || $apellido === "" || $matricula === "" || $id_especialidad === "") {
        $mensaje = "Debe ingresar un nombre, un apellido, una matrícula y seleccionar una especialidad.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO medico (nombre, apellido, matricula, id_especialidad)
                VALUES (:nombre, :apellido, :matricula, :id_especialidad)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'          => $nombre,
                ':apellido'        => $apellido,
                ':matricula'       => $matricula,
                ':id_especialidad' => (int)$id_especialidad
            ]);

            $mensaje = "Médico registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el médico. La matrícula ya existe.";
            $tipo_mensaje = "error";
        }
    }
}

$especialidades = $pdo->query("SELECT id_especialidad, nombre FROM especialidad ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar médico</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TURNOS CLÍNICA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Médicos ]</a>
        <a href="alta.php">[ Nuevo médico ]</a>
        <a href="../especialidad/listar.php">[ Especialidades ]</a>
        <a href="../turno/listar.php">[ Turnos ]</a>
    </nav>
</header>

<main>

    <h2>Registrar médico</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <label for="apellido">Apellido <span class="requerido">*</span></label>
        <input type="text" name="apellido" id="apellido" required
               value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>">

        <label for="matricula">Matrícula <span class="requerido">*</span></label>
        <input type="text" name="matricula" id="matricula" required
               value="<?= htmlspecialchars($_POST['matricula'] ?? '') ?>">

        <label for="id_especialidad">Especialidad <span class="requerido">*</span></label>
        <select name="id_especialidad" id="id_especialidad" required>
            <option value="">Seleccione una especialidad</option>
            <?php foreach ($especialidades as $especialidad) { ?>
                <option value="<?= $especialidad['id_especialidad'] ?>">
                    <?= htmlspecialchars($especialidad['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Registrar médico</button>

    </form>

    <p><a href="listar.php">Volver al listado de médicos</a></p>

</main>

</body>
</html>