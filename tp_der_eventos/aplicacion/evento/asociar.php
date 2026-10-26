<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

$id = (int)($_GET["id"] ?? $_POST["id_evento"] ?? 0);

// --- PROCESAR ASOCIACIÓN ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_expositor"]) && $id > 0) {

    $id_expositor = (int)($_POST["id_expositor"] ?? 0);

    if ($id_expositor === 0) {
        $mensaje = "Debe seleccionar un expositor.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO evento_expositor (id_evento, id_expositor) VALUES (:id_evento, :id_expositor)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_evento'    => $id,
                ':id_expositor' => $id_expositor
            ]);

            $mensaje = "Expositor asociado al evento correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo asociar. Puede que ya estén vinculados.";
            $tipo_mensaje = "error";
        }
    }
}

// --- OBTENER TODOS LOS EVENTOS (selector si no hay id) ---
$eventos = $pdo->query(
    "SELECT id_evento, nombre, fecha FROM evento ORDER BY fecha DESC"
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asociar expositores con eventos</title>
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
        <a href="../inscripcion/listar.php">[ Inscripciones ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($id === 0) { ?>

        <!-- SIN EVENTO SELECCIONADO -->
        <h2>Asociar expositores con un evento</h2>

        <form action="asociar.php" method="get">

            <label for="id">Evento <span class="requerido">*</span></label>
            <select name="id" id="id" required>
                <option value="">Seleccione un evento</option>
                <?php foreach ($eventos as $ev) { ?>
                    <option value="<?= $ev['id_evento'] ?>">
                        <?= htmlspecialchars($ev['nombre'] . " (" . $ev['fecha'] . ")") ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit">Continuar</button>

        </form>

        <p><a href="listar.php">Volver al listado de eventos</a></p>

    <?php } else { ?>

        <?php
        $sql_ev = "SELECT e.id_evento, e.nombre, e.fecha, e.horario, e.lugar, t.nombre AS tipo
                   FROM evento e
                   INNER JOIN tipo_evento t ON e.id_tipo = t.id_tipo
                   WHERE e.id_evento = :id_evento";

        $stmt_ev = $pdo->prepare($sql_ev);
        $stmt_ev->execute([':id_evento' => $id]);
        $evento = $stmt_ev->fetch();

        if (!$evento) {

            echo '<p class="mensaje error">El evento solicitado no existe.</p>';
            echo '<p><a href="asociar.php">Elegir otro evento</a></p>';

        } else {

            $sql_expo_evento = "SELECT x.id_expositor, x.nombre, x.apellido, x.tema_exposicion, x.email
                                FROM evento_expositor ee
                                INNER JOIN expositor x ON ee.id_expositor = x.id_expositor
                                WHERE ee.id_evento = :id_evento
                                ORDER BY x.apellido, x.nombre";

            $stmt_expo_evento = $pdo->prepare($sql_expo_evento);
            $stmt_expo_evento->execute([':id_evento' => $id]);
            $expositores_evento = $stmt_expo_evento->fetchAll();

            $todos_expositores = $pdo->query("SELECT id_expositor, nombre, apellido, tema_exposicion FROM expositor ORDER BY apellido")->fetchAll();
        ?>

        <h2>Asociar expositores a: <?= htmlspecialchars($evento['nombre']) ?></h2>

        <p>
            <strong>Fecha:</strong> <?= htmlspecialchars($evento['fecha']) ?><br>
            <strong>Horario:</strong> <?= htmlspecialchars($evento['horario']) ?><br>
            <strong>Lugar:</strong> <?= htmlspecialchars((string)$evento['lugar']) ?><br>
            <strong>Tipo:</strong> <?= htmlspecialchars($evento['tipo']) ?>
        </p>

        <h3>Expositores vinculados a este evento</h3>

        <table>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Tema</th>
                <th>Correo</th>
            </tr>
            <?php if (empty($expositores_evento)) { ?>
            <tr>
                <td colspan="4">Todavía no hay expositores asociados a este evento.</td>
            </tr>
            <?php } else { ?>
                <?php foreach ($expositores_evento as $exp) { ?>
                <tr>
                    <td><?= htmlspecialchars($exp['nombre']) ?></td>
                    <td><?= htmlspecialchars($exp['apellido']) ?></td>
                    <td><?= htmlspecialchars((string)$exp['tema_exposicion']) ?></td>
                    <td><?= htmlspecialchars((string)$exp['email']) ?></td>
                </tr>
                <?php } ?>
            <?php } ?>
        </table>

        <h3>Agregar expositor al evento</h3>

        <form action="asociar.php?id=<?= $id ?>" method="post">

            <input type="hidden" name="id_evento" value="<?= $id ?>">

            <label for="id_expositor">Expositor <span class="requerido">*</span></label>
            <select name="id_expositor" id="id_expositor" required>
                <option value="">Seleccione un expositor</option>
                <?php foreach ($todos_expositores as $exp) { ?>
                    <option value="<?= $exp['id_expositor'] ?>">
                        <?= htmlspecialchars($exp['apellido'] . ", " . $exp['nombre'] . " — " . (string)$exp['tema_exposicion']) ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit">Agregar expositor</button>

        </form>

        <p><a href="asociar.php">Elegir otro evento</a> · <a href="listar.php">Volver al listado</a></p>

        <?php } ?>

    <?php } ?>

</main>

</body>
</html>