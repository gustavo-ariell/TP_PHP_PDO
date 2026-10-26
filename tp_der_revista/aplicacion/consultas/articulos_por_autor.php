<?php
require_once "../conexion.php";

$autores = $pdo->query("SELECT id_autor, nombre, apellido FROM autor ORDER BY apellido")->fetchAll();

$articulos = [];
$autorSeleccionado = null;
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_autor = $_POST["id_autor"] ?? "";

    if (!ctype_digit($id_autor)) {
        $error = "Debe seleccionar un autor.";
    } else {

        $sql = "SELECT ar.id_articulo,
                       ar.titulo,
                       ar.fecha_envio,
                       ar.palabras_clave,
                       s.nombre AS seccion,
                       e.nombre AS estado
                FROM articulo ar
                INNER JOIN articulo_autor aa ON ar.id_articulo = aa.id_articulo
                INNER JOIN seccion s ON ar.id_seccion = s.id_seccion
                INNER JOIN estado_articulo e ON ar.id_estado = e.id_estado
                WHERE aa.id_autor = :id_autor
                ORDER BY ar.fecha_envio DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_autor' => (int)$id_autor]);
        $articulos = $stmt->fetchAll();

        foreach ($autores as $au) {
            if ($au['id_autor'] == $id_autor) {
                $autorSeleccionado = $au;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Artículos por autor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>CONSULTA: ARTÍCULOS POR AUTOR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="articulos_por_estado.php">[ Artículos por estado ]</a>
    </nav>
</header>

<main>

    <?php if ($error !== ""): ?>
        <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <h2>Seleccione un autor</h2>

    <form action="articulos_por_autor.php" method="POST">
        <label>Autor</label>
        <select name="id_autor" required>
            <option value="">-- Seleccione un autor --</option>
            <?php foreach ($autores as $au): ?>
                <option value="<?= $au['id_autor'] ?>">
                    <?= htmlspecialchars($au['apellido'] . ", " . $au['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Buscar</button>
    </form>

    <?php if ($autorSeleccionado): ?>
        <h2>Artículos de <?= htmlspecialchars($autorSeleccionado['apellido'] . ", " . $autorSeleccionado['nombre']) ?></h2>

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
            <div class="mensaje error">Este autor no tiene artículos registrados.</div>
        <?php endif; ?>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Publicaciones de una Revista Académica</p>
</footer>

</body>
</html>