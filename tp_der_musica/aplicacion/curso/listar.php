<?php
require_once "../conexion.php";

$sql = "SELECT c.id_curso, c.dia, c.horario, c.cupo_maximo,
               i.nombre AS instrumento,
               d.nombre AS docente_nombre, d.apellido AS docente_apellido
        FROM curso c
        INNER JOIN instrumento i ON c.id_instrumento = i.id_instrumento
        INNER JOIN docente d ON c.id_docente = d.id_docente
        ORDER BY c.dia, c.horario";

$cursos = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar cursos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>CURSOS</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="alta.php">[ Registrar curso ]</a>
    </nav>
</header>

<main>

    <h2>Listado de cursos</h2>

    <?php if (count($cursos) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Instrumento</th>
                    <th>Docente</th>
                    <th>Día</th>
                    <th>Horario</th>
                    <th>Cupo máximo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cursos as $cur): ?>
                    <tr>
                        <td><?= $cur['id_curso'] ?></td>
                        <td><?= htmlspecialchars($cur['instrumento']) ?></td>
                        <td><?= htmlspecialchars($cur['docente_apellido'] . ", " . $cur['docente_nombre']) ?></td>
                        <td><?= htmlspecialchars($cur['dia']) ?></td>
                        <td><?= htmlspecialchars($cur['horario']) ?></td>
                        <td><?= $cur['cupo_maximo'] ?></td>
                        <td>
                            <a class="btn-editar" href="editar.php?id=<?= $cur['id_curso'] ?>">Editar</a>
                            <a class="btn-eliminar" href="eliminar.php?id=<?= $cur['id_curso'] ?>"
                               onclick="return confirm('¿Eliminar curso?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="mensaje error">No hay cursos registrados.</div>
    <?php endif; ?>

</main>

<footer>
    <p>Trabajo Práctico — Gestión de Escuela de Música</p>
</footer>

</body>
</html>