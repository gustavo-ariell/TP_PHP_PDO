<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_evento = (int)($_POST["id_evento"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $fecha = $_POST["fecha"] ?? "";
    $horario = $_POST["horario"] ?? "";
    $lugar = trim($_POST["lugar"] ?? "");
    $id_tipo = $_POST["id_tipo"] ?? "";

    if ($nombre === "" || $fecha === "" || $horario === "" || $id_tipo === "") {
        $mensaje = "Debe completar todos los campos obligatorios.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE evento SET
                    nombre = :nombre,
                    descripcion = :descripcion,
                    fecha = :fecha,
                    horario = :horario,
                    lugar = :lugar,
                    id_tipo = :id_tipo
                WHERE id_evento = :id_evento";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'      => $nombre,
                ':descripcion' => $descripcion,
                ':fecha'       => $fecha,
                ':horario'     => $horario,
                ':lugar'       => $lugar,
                ':id_tipo'     => (int)$id_tipo,
                ':id_evento'   => $id_evento
            ]);

            $mensaje = "Evento modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el evento.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_evento"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_evento, nombre, descripcion, fecha, horario, lugar, id_tipo
        FROM evento WHERE id_evento = :id_evento";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_evento' => $id]);
$evento = $stmt->fetch();

if (!$evento) {
    die("El evento solicitado no existe.");
}

$tipos = $pdo->query("SELECT id_tipo, nombre FROM tipo_evento ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar evento</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Eventos ]</a>
    </nav>
</header>

<main>

    <h2>Modificar evento</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_evento" value="<?= $evento['id_evento'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($evento['nombre']) ?>">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3"><?= htmlspecialchars((string)$evento['descripcion']) ?></textarea>

        <label for="fecha">Fecha <span class="requerido">*</span></label>
        <input type="date" name="fecha" id="fecha" required
               value="<?= htmlspecialchars($evento['fecha']) ?>">

        <label for="horario">Horario <span class="requerido">*</span></label>
        <input type="time" name="horario" id="horario" required
               value="<?= htmlspecialchars($evento['horario']) ?>">

        <label for="lugar">Lugar</label>
        <input type="text" name="lugar" id="lugar"
               value="<?= htmlspecialchars((string)$evento['lugar']) ?>">

        <label for="id_tipo">Tipo de evento <span class="requerido">*</span></label>
        <select name="id_tipo" id="id_tipo" required>
            <?php foreach ($tipos as $tipo) { ?>
                <option value="<?= $tipo['id_tipo'] ?>"
                    <?= $tipo['id_tipo'] == $evento['id_tipo'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($tipo['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>