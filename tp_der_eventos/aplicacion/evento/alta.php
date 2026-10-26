<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $fecha = $_POST["fecha"] ?? "";
    $horario = $_POST["horario"] ?? "";
    $lugar = trim($_POST["lugar"] ?? "");
    $id_tipo = $_POST["id_tipo"] ?? "";

    if ($nombre === "" || $fecha === "" || $horario === "" || $id_tipo === "") {
        $mensaje = "Debe ingresar nombre, fecha, horario y seleccionar un tipo de evento.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO evento (nombre, descripcion, fecha, horario, lugar, id_tipo)
                VALUES (:nombre, :descripcion, :fecha, :horario, :lugar, :id_tipo)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'      => $nombre,
                ':descripcion' => $descripcion,
                ':fecha'       => $fecha,
                ':horario'     => $horario,
                ':lugar'       => $lugar,
                ':id_tipo'     => (int)$id_tipo
            ]);

            $id_evento = $pdo->lastInsertId();

            header("Location: asociar.php?id=" . $id_evento);
            exit;

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el evento.";
            $tipo_mensaje = "error";
        }
    }
}

$tipos = $pdo->query("SELECT id_tipo, nombre FROM tipo_evento ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar evento</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Eventos ]</a>
        <a href="alta.php">[ Nuevo evento ]</a>
        <a href="../expositor/listar.php">[ Expositores ]</a>
        <a href="../asistente/listar.php">[ Asistentes ]</a>
        <a href="../inscripcion/listar.php">[ Inscripciones ]</a>
    </nav>
</header>

<main>

    <h2>Registrar evento</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>

        <label for="fecha">Fecha <span class="requerido">*</span></label>
        <input type="date" name="fecha" id="fecha" required
               value="<?= htmlspecialchars($_POST['fecha'] ?? '') ?>">

        <label for="horario">Horario <span class="requerido">*</span></label>
        <input type="time" name="horario" id="horario" required
               value="<?= htmlspecialchars($_POST['horario'] ?? '') ?>">

        <label for="lugar">Lugar</label>
        <input type="text" name="lugar" id="lugar"
               value="<?= htmlspecialchars($_POST['lugar'] ?? '') ?>">

        <label for="id_tipo">Tipo de evento <span class="requerido">*</span></label>
        <select name="id_tipo" id="id_tipo" required>
            <option value="">Seleccione un tipo</option>
            <?php foreach ($tipos as $tipo) { ?>
                <option value="<?= $tipo['id_tipo'] ?>"
                    <?= ($_POST['id_tipo'] ?? '') == $tipo['id_tipo'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($tipo['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Registrar evento y asociar expositores</button>

    </form>

    <p><a href="listar.php">Volver al listado de eventos</a></p>

</main>

</body>
</html>