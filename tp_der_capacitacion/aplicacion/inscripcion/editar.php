<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$inscripcion = null;

// Cargar datos si viene por GET
if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {

    $sql = "SELECT i.id_inscripcion,
                   i.fecha_inscripcion,
                   i.estado,
                   i.calificacion_final,
                   i.id_estudiante,
                   i.id_curso,
                   e.nombre AS est_nombre,
                   e.apellido AS est_apellido,
                   c.nombre AS curso_nombre
            FROM inscripcion i
            INNER JOIN estudiante e ON i.id_estudiante = e.id_estudiante
            INNER JOIN curso c ON i.id_curso = c.id_curso
            WHERE i.id_inscripcion = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => (int)$_GET["id"]]);
    $inscripcion = $stmt->fetch();

    if (!$inscripcion) {
        $mensaje = "La inscripción solicitada no existe.";
        $tipo_mensaje = "error";
    }
}

// Procesar modificación si viene por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id                = $_POST["id_inscripcion"] ?? "";
    $estado            = $_POST["estado"] ?? "";
    $calificacion      = trim($_POST["calificacion_final"] ?? "");

    $estadosValidos = ["activa", "finalizada", "cancelada"];

    if (!ctype_digit($id)) {
        $mensaje = "Identificador inválido.";
        $tipo_mensaje = "error";
    } elseif (!in_array($estado, $estadosValidos)) {
        $mensaje = "Debe seleccionar un estado válido.";
        $tipo_mensaje = "error";
    } elseif ($calificacion !== "" && (!is_numeric($calificacion) || (float)$calificacion < 0 || (float)$calificacion > 10)) {
        $mensaje = "La calificación debe ser un número entre 0 y 10.";
        $tipo_mensaje = "error";
    } else {

        // Si el estado es "finalizada", la calificación es obligatoria
        if ($estado === "finalizada" && $calificacion === "") {
            $mensaje = "Para finalizar una inscripción debe ingresar la calificación.";
            $tipo_mensaje = "error";
        } else {

            // Si no se ingresó calificación, queda en NULL
            $calificacion = ($calificacion === "") ? null : (float)$calificacion;

            // Si la inscripción se cancela o queda activa, limpiar calificación
            if ($estado !== "finalizada") {
                $calificacion = null;
            }

            try {

                $sql = "UPDATE inscripcion
                        SET estado = :estado,
                            calificacion_final = :calificacion
                        WHERE id_inscripcion = :id";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':estado'       => $estado,
                    ':calificacion' => $calificacion,
                    ':id'           => (int)$id
                ]);

                $mensaje = "Inscripción modificada correctamente.";
                $tipo_mensaje = "exito";

                // Recargar datos actualizados
                $sql2 = "SELECT i.id_inscripcion,
                                i.fecha_inscripcion,
                                i.estado,
                                i.calificacion_final,
                                i.id_estudiante,
                                i.id_curso,
                                e.nombre AS est_nombre,
                                e.apellido AS est_apellido,
                                c.nombre AS curso_nombre
                         FROM inscripcion i
                         INNER JOIN estudiante e ON i.id_estudiante = e.id_estudiante
                         INNER JOIN curso c ON i.id_curso = c.id_curso
                         WHERE i.id_inscripcion = :id";

                $stmt2 = $pdo->prepare($sql2);
                $stmt2->execute([':id' => (int)$id]);
                $inscripcion = $stmt2->fetch();

            } catch (PDOException $e) {
                $mensaje = "No se pudo modificar la inscripción.";
                $tipo_mensaje = "error";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar inscripción</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>MODIFICAR ESTADO / CALIFICAR INSCRIPCIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar inscripciones ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <?php if ($inscripcion): ?>

        <h2>Datos de la inscripción #<?= $inscripcion['id_inscripcion'] ?></h2>

        <table>
            <tbody>
                <tr>
                    <th>Estudiante</th>
                    <td><?= htmlspecialchars($inscripcion['est_apellido'] . ", " . $inscripcion['est_nombre']) ?></td>
                </tr>
                <tr>
                    <th>Curso</th>
                    <td><?= htmlspecialchars($inscripcion['curso_nombre']) ?></td>
                </tr>
                <tr>
                    <th>Fecha inscripción</th>
                    <td><?= htmlspecialchars($inscripcion['fecha_inscripcion']) ?></td>
                </tr>
                <tr>
                    <th>Estado actual</th>
                    <td><?= htmlspecialchars($inscripcion['estado']) ?></td>
                </tr>
                <tr>
                    <th>Calificación actual</th>
                    <td><?= $inscripcion['calificacion_final'] !== null ? number_format((float)$inscripcion['calificacion_final'], 2, ",", ".") : '—' ?></td>
                </tr>
            </tbody>
        </table>

        <h2>Modificar estado y calificación</h2>

        <form action="editar.php" method="POST">

            <input type="hidden" name="id_inscripcion" value="<?= $inscripcion['id_inscripcion'] ?>">

            <label>Estado <span class="requerido">*</span></label>
            <select name="estado" required>
                <option value="activa" <?= $inscripcion['estado'] === 'activa' ? 'selected' : '' ?>>
                    Activa
                </option>
                <option value="finalizada" <?= $inscripcion['estado'] === 'finalizada' ? 'selected' : '' ?>>
                    Finalizada
                </option>
                <option value="cancelada" <?= $inscripcion['estado'] === 'cancelada' ? 'selected' : '' ?>>
                    Cancelada
                </option>
            </select>

            <label>Calificación final (0 a 10, obligatoria si el estado es "finalizada")</label>
            <input type="number" name="calificacion_final" step="0.01" min="0" max="10"
                   value="<?= $inscripcion['calificacion_final'] !== null ? $inscripcion['calificacion_final'] : '' ?>">

            <button type="submit">Guardar cambios</button>

        </form>

    <?php else: ?>

        <div class="mensaje error">
            No se pudo cargar la inscripción. <a href="listar.php">Volver al listado</a>
        </div>

    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Cursos de Capacitación</p>
</footer>

</body>
</html>
