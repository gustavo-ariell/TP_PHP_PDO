<?php
require_once "../conexion.php";

$mensaje = "";
$error   = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_estudiante = $_POST["id_estudiante"] ?? "";
    $id_curso      = $_POST["id_curso"] ?? "";
    $fecha         = $_POST["fecha_inscripcion"] ?? "";

    if (!ctype_digit($id_estudiante) || !ctype_digit($id_curso)) {
        $error = "Debe seleccionar un estudiante y un curso.";
    } elseif ($fecha === "") {
        $error = "Debe ingresar la fecha de inscripción.";
    } else {

        // Verificar cupo disponible
        $sqlCupo = "SELECT c.cupo_maximo,
                           (SELECT COUNT(*) FROM inscripcion WHERE id_curso = c.id_curso) AS inscriptos
                    FROM curso c WHERE c.id_curso = :id_curso";
        $stmtCupo = $pdo->prepare($sqlCupo);
        $stmtCupo->execute([":id_curso" => $id_curso]);
        $cupo = $stmtCupo->fetch();

        if (!$cupo) {
            $error = "El curso seleccionado no existe.";
        } elseif ((int)$cupo["inscriptos"] >= (int)$cupo["cupo_maximo"]) {
            $error = "El curso ya alcanzó el cupo máximo.";
        } else {

            try {

                $sql = "INSERT INTO inscripcion (id_estudiante, id_curso, fecha_inscripcion)
                        VALUES (:id_estudiante, :id_curso, :fecha_inscripcion)";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ":id_estudiante"     => $id_estudiante,
                    ":id_curso"          => $id_curso,
                    ":fecha_inscripcion" => $fecha
                ]);

                $mensaje = "Inscripción registrada correctamente.";

            } catch (PDOException $e) {
                $error = "No se pudo registrar la inscripción.";
            }
        }
    }
}

// Listas desplegables dinámicas
$estudiantes = $pdo->query("SELECT id_estudiante, nombre, apellido FROM estudiante ORDER BY apellido")->fetchAll();

$sqlCur = "SELECT c.id_curso, i.nombre AS instrumento, d.apellido AS docente_apellido,
                  d.nombre AS docente_nombre, c.dia, c.horario
           FROM curso c
           INNER JOIN instrumento i ON c.id_instrumento = i.id_instrumento
           INNER JOIN docente d ON c.id_docente = d.id_docente
           ORDER BY c.dia, c.horario";
$cursos = $pdo->query($sqlCur)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Realizar inscripción</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>REALIZAR INSCRIPCIÓN</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar inscripciones ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje exito"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <?php if ($error !== ""): ?>
        <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <h2>Nueva inscripción</h2>

    <form action="alta.php" method="POST">

        <label>Estudiante <span class="requerido">*</span></label>
        <select name="id_estudiante" required>
            <option value="">-- Seleccione un estudiante --</option>
            <?php foreach ($estudiantes as $est): ?>
                <option value="<?= $est['id_estudiante'] ?>">
                    <?= htmlspecialchars($est['apellido'] . ", " . $est['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Curso <span class="requerido">*</span></label>
        <select name="id_curso" required>
            <option value="">-- Seleccione un curso --</option>
            <?php foreach ($cursos as $cur): ?>
                <option value="<?= $cur['id_curso'] ?>">
                    <?= htmlspecialchars($cur['instrumento'] . " — " . $cur['docente_apellido'] . ", " . $cur['docente_nombre'] . " (" . $cur['dia'] . " " . $cur['horario'] . ")") ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Fecha de inscripción <span class="requerido">*</span></label>
        <input type="date" name="fecha_inscripcion" required>

        <button type="submit">Registrar inscripción</button>
    </form>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>