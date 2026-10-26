<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

$id = (int)($_GET["id"] ?? $_POST["id_libro"] ?? 0);

// --- PROCESAR ASOCIACIÓN ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_autor"]) && $id > 0) {

    $id_autor = (int)($_POST["id_autor"] ?? 0);

    if ($id_autor === 0) {
        $mensaje = "Debe seleccionar un autor.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO libro_autor (id_libro, id_autor) VALUES (:id_libro, :id_autor)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_libro' => $id,
                ':id_autor' => $id_autor
            ]);

            $mensaje = "Autor asociado al libro correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo asociar. Puede que ya estén vinculados.";
            $tipo_mensaje = "error";
        }
    }
}

// --- OBTENER TODOS LOS LIBROS (selector si no hay id) ---
$libros = $pdo->query("SELECT id_libro, titulo, anio FROM libro_digital ORDER BY titulo")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asociar autores a libro</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE BIBLIOTECA DIGITAL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Libros ]</a>
        <a href="alta.php">[ Nuevo libro ]</a>
        <a href="../autor/listar.php">[ Autores ]</a>
        <a href="../usuario/listar.php">[ Usuarios ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($id === 0) { ?>

        <h2>Asociar autores a un libro</h2>

        <form action="asociar.php" method="get">

            <label for="id">Libro <span class="requerido">*</span></label>
            <select name="id" id="id" required>
                <option value="">Seleccione un libro</option>
                <?php foreach ($libros as $libro) { ?>
                    <option value="<?= $libro['id_libro'] ?>">
                        <?= htmlspecialchars($libro['titulo'] . " (" . (string)$libro['anio'] . ")") ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit">Continuar</button>

        </form>

        <p><a href="listar.php">Volver al listado de libros</a></p>

    <?php } else { ?>

        <?php
        $sql_libro = "SELECT id_libro, titulo, descripcion, anio, idioma, id_categoria
                      FROM libro_digital WHERE id_libro = :id_libro";

        $stmt_libro = $pdo->prepare($sql_libro);
        $stmt_libro->execute([':id_libro' => $id]);
        $libro = $stmt_libro->fetch();

        if (!$libro) {

            echo '<p class="mensaje error">El libro solicitado no existe.</p>';
            echo '<p><a href="asociar.php">Elegir otro libro</a></p>';

        } else {

            $sql_autores_libro = "SELECT a.id_autor, a.nombre, a.apellido, a.nacionalidad
                                  FROM libro_autor la
                                  INNER JOIN autor a ON la.id_autor = a.id_autor
                                  WHERE la.id_libro = :id_libro
                                  ORDER BY a.apellido, a.nombre";

            $stmt_autores_libro = $pdo->prepare($sql_autores_libro);
            $stmt_autores_libro->execute([':id_libro' => $id]);
            $autores_libro = $stmt_autores_libro->fetchAll();

            $todos_autores = $pdo->query("SELECT id_autor, nombre, apellido, nacionalidad FROM autor ORDER BY apellido")->fetchAll();
        ?>

        <h2>Asociar autores a: <?= htmlspecialchars($libro['titulo']) ?></h2>

        <p>
            <strong>Año:</strong> <?= $libro['anio'] !== null ? htmlspecialchars((string)$libro['anio']) : "—" ?><br>
            <strong>Idioma:</strong> <?= htmlspecialchars((string)$libro['idioma']) ?>
        </p>

        <h3>Autores vinculados a este libro</h3>

        <table>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Nacionalidad</th>
            </tr>
            <?php if (empty($autores_libro)) { ?>
            <tr>
                <td colspan="3">Todavía no hay autores asociados a este libro.</td>
            </tr>
            <?php } else { ?>
                <?php foreach ($autores_libro as $autor) { ?>
                <tr>
                    <td><?= htmlspecialchars($autor['nombre']) ?></td>
                    <td><?= htmlspecialchars($autor['apellido']) ?></td>
                    <td><?= htmlspecialchars((string)$autor['nacionalidad']) ?></td>
                </tr>
                <?php } ?>
            <?php } ?>
        </table>

        <h3>Agregar autor al libro</h3>

        <form action="asociar.php?id=<?= $id ?>" method="post">

            <input type="hidden" name="id_libro" value="<?= $id ?>">

            <label for="id_autor">Autor <span class="requerido">*</span></label>
            <select name="id_autor" id="id_autor" required>
                <option value="">Seleccione un autor</option>
                <?php foreach ($todos_autores as $autor) { ?>
                    <option value="<?= $autor['id_autor'] ?>">
                        <?= htmlspecialchars($autor['apellido'] . ", " . $autor['nombre']) ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit">Agregar autor</button>

        </form>

        <p><a href="asociar.php">Elegir otro libro</a> · <a href="listar.php">Volver al listado</a></p>

        <?php } ?>

    <?php } ?>

</main>

</body>
</html>