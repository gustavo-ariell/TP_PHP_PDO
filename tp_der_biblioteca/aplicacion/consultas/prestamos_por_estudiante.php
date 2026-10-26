<?php
require_once "../conexion.php";

$estudiantes = $pdo->query("SELECT id_estudiante, nombre, apellido FROM estudiante ORDER BY apellido")->fetchAll();

$id_estudiante = $_POST["id_estudiante"] ?? "";
$prestamos = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_estudiante !== "") {

    $sql = "SELECT
                p.id_prestamo,
                l.titulo,
                p.fecha_prestamo,
                p.fecha_devolucion_estimada,
                p.fecha_devolucion_real
            FROM prestamo p
            INNER JOIN libro l ON p.id_libro = l.id_libro
            INNER JOIN estudiante e ON p.id_estudiante = e.id_estudiante
            WHERE p.id_estudiante = :id_estudiante
            ORDER BY p.fecha_prestamo";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_estudiante' => (int)$id_estudiante]);
    $prestamos = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Préstamos por estudiante</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="libros_disponibles.php">[ Disponibles ]</a>
        <a href="libros_prestados.php">[ Prestados ]</a>
        <a href="prestamos_por_estudiante.php">[ Por estudiante ]</a>
        <a href="libros_autores.php">[ Libros y autores ]</a>
        <a href="../prestamo/listar.php">[ Préstamos ]</a>
    </nav>
</header>

<main>

    <h2>Préstamos realizados por estudiante</h2>

    <form action="prestamos_por_estudiante.php" method="post">

        <label for="id_estudiante">Estudiante <span class="requerido">*</span></label>
        <select name="id_estudiante" id="id_estudiante" required>
            <option value="">Seleccione un estudiante</option>
            <?php foreach ($estudiantes as $estudiante) { ?>
                <option value="<?= $estudiante['id_estudiante'] ?>"
                    <?= $estudiante['id_estudiante'] == $id_estudiante ? "selected" : "" ?>>
                    <?= htmlspecialchars($estudiante['nombre'] . " " . $estudiante['apellido']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Consultar</button>

    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Fecha de préstamo</th>
                <th>Devolución estimada</th>
                <th>Devolución real</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($prestamos as $prestamo) { ?>
            <tr>
                <td><?= $prestamo['id_prestamo'] ?></td>
                <td><?= htmlspecialchars($prestamo['titulo']) ?></td>
                <td><?= htmlspecialchars($prestamo['fecha_prestamo']) ?></td>
                <td><?= htmlspecialchars((string)$prestamo['fecha_devolucion_estimada']) ?></td>
                <td><?= htmlspecialchars((string)$prestamo['fecha_devolucion_real']) ?></td>
                <td>
                    <?= $prestamo['fecha_devolucion_real'] === null ? "Pendiente" : "Devuelto" ?>
                </td>
            </tr>
            <?php } ?>
        </table>

    <?php } ?>

</main>

</body>
</html>