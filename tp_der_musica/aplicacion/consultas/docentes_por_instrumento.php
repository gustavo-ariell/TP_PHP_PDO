<?php
require_once "../conexion.php";

$instrumentos = $pdo->query("SELECT id_instrumento, nombre FROM instrumento ORDER BY nombre")->fetchAll();

$docentes = [];
$instrumentoSeleccionado = null;
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_instrumento = $_POST["id_instrumento"] ?? "";

    if (!ctype_digit($id_instrumento)) {
        $error = "Debe seleccionar un instrumento.";
    } else {

        $sql = "SELECT d.id_docente, d.nombre, d.apellido, d.email
                FROM docente d
                WHERE d.id_instrumento = :id_instrumento
                ORDER BY d.apellido";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id_instrumento" => $id_instrumento]);
        $docentes = $stmt->fetchAll();

        foreach ($instrumentos as $inst) {
            if ($inst['id_instrumento'] == $id_instrumento) {
                $instrumentoSeleccionado = $inst;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Docentes por instrumento</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>CONSULTA: DOCENTES POR INSTRUMENTO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="estudiantes_por_curso.php">[ Estudiantes por curso ]</a>
        <a href="horarios_clases.php">[ Horarios de clases ]</a>
    </nav>
</header>

<main>

    <?php if ($error !== ""): ?>
        <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <h2>Seleccione un instrumento</h2>

    <form action="docentes_por_instrumento.php" method="POST">
        <label>Instrumento</label>
        <select name="id_instrumento" required>
            <option value="">-- Seleccione un instrumento --</option>
            <?php foreach ($instrumentos as $inst): ?>
                <option value="<?= $inst['id_instrumento'] ?>">
                    <?= htmlspecialchars($inst['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Buscar</button>
    </form>

    <?php if ($instrumentoSeleccionado): ?>
        <h2>Docentes de <?= htmlspecialchars($instrumentoSeleccionado['nombre']) ?></h2>

        <?php if (count($docentes) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($docentes as $doc): ?>
                        <tr>
                            <td><?= $doc['id_docente'] ?></td>
                            <td><?= htmlspecialchars($doc['nombre']) ?></td>
                            <td><?= htmlspecialchars($doc['apellido']) ?></td>
                            <td><?= htmlspecialchars($doc['email'] ?? '—') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="mensaje error">No hay docentes para este instrumento.</div>
        <?php endif; ?>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>
