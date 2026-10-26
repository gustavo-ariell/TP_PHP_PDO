<?php
require_once "../conexion.php";

$eventos = $pdo->query("SELECT id_evento, nombre, fecha FROM evento ORDER BY fecha DESC")->fetchAll();

$id_evento = $_POST["id_evento"] ?? "";
$expositores = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_evento !== "") {

    $sql = "SELECT
                x.nombre,
                x.apellido,
                x.tema_exposicion,
                x.email
            FROM evento_expositor ee
            INNER JOIN expositor x ON ee.id_expositor = x.id_expositor
            INNER JOIN evento e ON ee.id_evento = e.id_evento
            WHERE ee.id_evento = :id_evento
            ORDER BY x.apellido, x.nombre";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_evento' => (int)$id_evento]);
    $expositores = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Expositores por evento</title>
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
        <a href="../expositor/listar.php">[ Expositores ]</a>
    </nav>
</header>

<main>

    <h2>Expositores por evento</h2>

    <form action="expositores_por_evento.php" method="post">

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
                <th>Tema de exposición</th>
                <th>Correo</th>
            </tr>
            <?php foreach ($expositores as $fila) { ?>
            <tr>
                <td><?= htmlspecialchars($fila['nombre']) ?></td>
                <td><?= htmlspecialchars($fila['apellido']) ?></td>
                <td><?= htmlspecialchars((string)$fila['tema_exposicion']) ?></td>
                <td><?= htmlspecialchars((string)$fila['email']) ?></td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>