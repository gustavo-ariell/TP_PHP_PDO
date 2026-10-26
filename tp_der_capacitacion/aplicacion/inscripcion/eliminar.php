<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";
$id = (int)($_GET["id"] ?? $_POST["id_inscripcion"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM inscripcion WHERE id_inscripcion = :id_inscripcion";

    try {

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_inscripcion' => $id]);

        $mensaje = "Inscripción eliminada correctamente.";
        $tipo_mensaje = "exito";

    } catch (PDOException $e) {
        $mensaje = "No se pudo eliminar la inscripción.";
        $tipo_mensaje = "error";
    }
}

$sql = "SELECT
            i.fecha_inscripcion,
            i.estado,
            e.nombre AS nombre_estudiante,
            e.apellido AS apellido_estudiante,
            c.nombre AS curso
        FROM inscripcion i
        INNER JOIN estudiante e ON i.id_estudiante = e.id_estudiante
       [ Inscripciones ]</a>
    </nav>
</header>

<main>

    <h2>Eliminar inscripción</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($inscripcion && $tipo_mensaje !== "exito") { ?>

        <p>¿Confirma que desea eliminar la inscripción de
           <strong><?= htmlspecialchars($inscripcion['nombre_estudiante'] . " " . $inscripcion['apellido_estudiante']) ?></strong>
           al curso <strong><?= htmlspecialchars($inscripcion['curso']) ?></strong>?</p>

        <form action="eliminar.php" method="post">
            <input type="hidden" name="id_inscripcion" value="<?= $id ?>">
            <button type="submit">Sí, eliminar</button>
            <a class="btn-editar" href="listar.php">Cancelar</a>
        </form>

    <?php } else { ?>

        <p><a href="listar.php">Volver al listado de inscripciones</a></p>

    <?php } ?>

</main>

</body>
</html>