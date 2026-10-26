<?php
require_once "../conexion.php";

$mensaje = "";
$error   = "";

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {

    try {

        // Verificar inscripciones asociadas
        $check = $pdo->prepare("SELECT COUNT(*) AS total FROM inscripcion WHERE id_estudiante = :id");
        $check->execute([":id" => $_GET["id"]]);
        $fila = $check->fetch();

        if ((int)$fila["total"] > 0) {
            $error = "No se puede eliminar: el estudiante tiene inscripciones registradas.";
        } else {

            $sql = "DELETE FROM estudiante WHERE id_estudiante = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([":id" => $_GET["id"]]);

            if ($stmt->rowCount() > 0) {
                $mensaje = "Estudiante eliminado correctamente.";
            } else {
                $error = "El estudiante no existe.";
            }
        }

    } catch (PDOException $e) {
        $error = "No se pudo eliminar el estudiante.";
    }
}

$estudiantes = $pdo->query("SELECT * FROM estudiante ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar estudiante</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>ELIMINAR ESTUDIANTE</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Listar estudiantes ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== ""): ?>
        <div class="mensaje exito"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <?php if ($error !== ""): ?>
        <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <h2>Listado de estudiantes</h2>

    <table>
        <thead>
            <tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>DNI</th><th>Acción</th></tr>
        </thead>
        <tbody>
            <?php foreach ($estudiantes as $est): ?>
                <tr>
                    <td><?= $est['id_estudiante'] ?></td>
                    <td><?= htmlspecialchars($est['nombre']) ?></td>
                    <td><?= htmlspecialchars($est['apellido']) ?></td>
                    <td><?= htmlspecialchars($est['dni']) ?></td>
                    <td>
                        <a class="btn-eliminar" href="eliminar.php?id=<?= $est['id_estudiante'] ?>"
                           onclick="return confirm('¿Eliminar estudiante?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>