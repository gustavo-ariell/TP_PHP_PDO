<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_libro = $_POST["id_libro"] ?? "";
    $id_estudiante = $_POST["id_estudiante"] ?? "";
    $fecha_prestamo = $_POST["fecha_prestamo"] ?? "";
    $fecha_devolucion_estimada = $_POST["fecha_devolucion_estimada"] ?? "";

    if ($id_libro === "" || $id_estudiante === "" || $fecha_prestamo === "") {

        $mensaje = "Debe seleccionar un libro, un estudiante e ingresar la fecha de préstamo.";
        $tipo_mensaje = "error";

    } elseif ($fecha_devolucion_estimada !== "" && $fecha_devolucion_estimada < $fecha_prestamo) {

        $mensaje = "La fecha de devolución estimada no puede ser anterior a la fecha de préstamo.";
        $tipo_mensaje = "error";

    } else {

        $sql = "INSERT INTO prestamo
                    (id_libro, id_estudiante, fecha_prestamo, fecha_devolucion_estimada, fecha_devolucion_real)
                VALUES
                    (:id_libro, :id_estudiante, :fecha_prestamo, :fecha_devolucion_estimada, NULL)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_libro'                  => (int)$id_libro,
                ':id_estudiante'             => (int)$id_estudiante,
                ':fecha_prestamo'            => $fecha_prestamo,
                ':fecha_devolucion_estimada' => ($fecha_devolucion_estimada === "" ? null : $fecha_devolucion_estimada)
            ]);

            $mensaje = "Préstamo registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el préstamo.";
            $tipo_mensaje = "error";
        }
    }
}

$libros = $pdo->query("SELECT id_libro, titulo FROM libro ORDER BY titulo")->fetchAll();
$estudiantes = $pdo->query("SELECT id_estudiante, nombre, apellido FROM estudiante ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar préstamo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA ESCOLAR</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Préstamos ]</a>
        <a href="alta.php">[ Nuevo préstamo ]</a>
        <a href="devolucion.php">[ Devoluciones ]</a>
        <a href="../libro/listar.php">[ Libros ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
    </nav>
</header>

<main>

    <h2>Registrar préstamo</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="id_libro">Libro <span class="requerido">*</span></label>
        <select name="id_libro" id="id_libro" required>
            <option value="">Seleccione un libro</option>
            <?php foreach ($libros as $libro) { ?>
                <option value="<?= $libro['id_libro'] ?>">
                    <?= htmlspecialchars($libro['titulo']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_estudiante">Estudiante <span class="requerido">*</span></label>
        <select name="id_estudiante" id="id_estudiante" required>
            <option value="">Seleccione un estudiante</option>
            <?php foreach ($estudiantes as $estudiante) { ?>
                <option value="<?= $estudiante['id_estudiante'] ?>">
                    <?= htmlspecialchars($estudiante['nombre'] . " " . $estudiante['apellido']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha_prestamo">Fecha de préstamo <span class="requerido">*</span></label>
        <input type="date" name="fecha_prestamo" id="fecha_prestamo" required
               value="<?= date('Y-m-d') ?>">

        <label for="fecha_devolucion_estimada">Fecha de devolución estimada</label>
        <input type="date" name="fecha_devolucion_estimada" id="fecha_devolucion_estimada">

        <button type="submit">Registrar préstamo</button>

    </form>

    <p><a href="listar.php">Volver al listado de préstamos</a></p>

</main>

</body>
</html>