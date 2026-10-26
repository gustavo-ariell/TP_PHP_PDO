<?php
require_once "../conexion.php";

$eventos = $pdo->query("SELECT id_evento, nombre, fecha FROM evento ORDER BY fecha DESC")->fetchAll();

$id_evento = $_POST["id_evento"] ?? "";
$asistentes = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_evento !== "") {

    $sql = "SELECT
                a.nombre,
                a.apellido,
                a.dni,
                a.email,
                a.institucion,
                i.fecha_inscripcion
            FROM inscripcion_evento i
            INNER JOIN asistente a ON i.id_asistente = a.id_asistente
            INNER JOIN evento e ON i.id_evento = e.id_evento
            WHERE i.id_evento = :id_evento
            ORDER BY a.apellido, a.nombre";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_evento' => (int)$id_evento]);
    $asistentes = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asistentes por evento</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE EVENTOS ACADÉMICOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="asistentes_por_evento.php">[ Asistentes por evento ]</a>
        <a href="expositores_por_evento.php">[ Expositores por evento ]</a>
        <a href="cantidad_inscritos.php">[ Cantidad inscritos ]</a>
        <a href="../inscripcion/listar.php">[ Inscripciones ]</a>
    </nav>
</header>

<main>

    <h2>Asistentes por evento</h2>

    <form action="asistentes_por_evento.php" method="post">

        <label for="id_evento">Evento <span class="requerido">*</span></label>
        <select name="id_evento" id="id_evento" required>
            <option value="">Seleccione un evento</option>
            <?php foreach ($eventos as $evento) { ?>
                <option value="<?= $evento['id_evento'] ?>"
                    <?= $evento['id_evento'] == $id_evento ? "selected" : "" ?>>
                    <?= htmlspecialchars($evento['nombre'] . " (" . $evento['fecha'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>

        <table>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Correo</th>
                <th>Institución</th>
                <th>Fecha inscripción</th>
            </tr>
            <?php foreach ($asistentes as $fila) { ?>
            <tr>
                <td><?= htmlspecialchars($fila['nombre']) ?></td>
                <td><?= htmlspecialchars($fila['apellido']) ?></td>
                <td><?= htmlspecialchars($fila['dni']) ?></td>
                <td><?= htmlspecialchars((string)$fila['email']) ?></td>
                <td><?= htmlspecialchars((string)$fila['institucion']) ?></td>
                <td><?= htmlspecialchars($fila['fecha_inscripcion']) ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>