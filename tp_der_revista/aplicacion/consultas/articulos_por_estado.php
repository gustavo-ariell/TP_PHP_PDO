<?php
require_once "../conexion.php";

$estados = $pdo->query("SELECT id_estado, nombre FROM estado_articulo ORDER BY nombre")->fetchAll();

$articulos = [];
$estadoSeleccionado = null;
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_estado = $_POST["id_estado"] ?? "";

    if (!ctype_digit($id_estado)) {
        $error = "Debe seleccionar un estado.";
    } else {

        $sql = "SELECT ar.id_articulo,
                       ar.titulo,
                       ar.fecha_envio,
                       ar.palabras_clave,
                       s.nombre AS seccion,
                       e.nombre AS estado
                FROM articulo ar
                INNER JOIN seccion s ON ar.id_seccion = s.id_seccion
                INNER JOIN estado_articulo e ON ar.id_estado = e.id_estado
                WHERE ar.id_estado = :id_estado
                ORDER BY ar.fecha_envio DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_estado' => (int)$id_estado]);
        $articulos = $stmt->fetchAll();

        foreach ($estados as $es) {
            if ($es['id_estado'] == $id_estado) {
                $estadoSeleccionado = $es;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Artículos por estado</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>CONSULTA: ARTÍCULOS POR ESTADO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="articulos_por_autor.php">[ Artículos por autor ]</a>
    </nav>
</header>

<main>

    <?php if ($error !== ""): ?>
        <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <h2>Seleccione un estado</h2>

    <form action="articulos_por_estado.php" method="POST">
        <label>Estado</label>
        <select name="id_estado" required>
            <option value="">-- Seleccione un estado --</option>
            <?php foreach ($estados as $es): ?>
                <option value="<?= $es['id_estado'] ?>">
                    <?= htmlspecialchars($es['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Buscar</button>
    </form>

    <?php if ($estadoSeleccionado): ?>
        <h2>Artículos con estado: <?= htmlspecialchars($estadoSeleccionado['nombre']) ?></h2>

        <?php if (count($articulos) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Fecha envío</th>
                        <th>Sección</th>
                        <th>Estado</th>
                        <th>Palabras clave</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articulos as $a): ?>
                        <tr>
                            <td><?= $a['id_articulo'] ?></td>
                            <td><?= htmlspecialchars($a['titulo']) ?></td>
                            <td><?= htmlspecialchars($a['fecha_envio']) ?></td>
                            <td><?= htmlspecialchars($a['seccion']) ?></td>
                            <td><?= htmlspecialchars($a['estado']) ?></td>
                            <td><?= htmlspecialchars($a['palabras_clave'] ?? '—') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="mensaje error">No hay artículos con este estado.</div>
        <?php endif; ?>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>