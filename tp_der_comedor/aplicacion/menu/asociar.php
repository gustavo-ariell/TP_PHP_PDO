<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

// Si viene un id por GET o POST, lo usamos. Si no, mostramos un selector.
$id = (int)($_GET["id"] ?? $_POST["id_menu"] ?? 0);

// --- PROCESAR AGREGADO DE PLATO ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_plato"]) && $id > 0) {

    $id_plato = (int)($_POST["id_plato"] ?? 0);

    if ($id_plato === 0) {

        $mensaje = "Debe seleccionar un plato.";
        $tipo_mensaje = "error";

    } else {

        $sql = "INSERT INTO menu_plato (id_menu, id_plato) VALUES (:id_menu, :id_plato)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_menu'  => $id,
                ':id_plato' => $id_plato
            ]);

            $mensaje = "Plato asociado al menú correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo asociar el plato. Puede que ya esté incluido en este menú.";
            $tipo_mensaje = "error";
        }
    }
}

// --- OBTENER TODOS LOS MENÚS (para el selector) ---
$menus = $pdo->query("SELECT id_menu, fecha, descripcion FROM menu ORDER BY fecha DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asociar platos al menú</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE COMEDOR UNIVERSITARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Menús ]</a>
        <a href="alta.php">[ Nuevo menú ]</a>
        <a href="../plato/listar.php">[ Platos ]</a>
        <a href="../reserva/listar.php">[ Reservas ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($id === 0) { ?>

        <!-- =================================================== -->
        <!-- SIN MENÚ SELECCIONADO: mostrar selector de menú    -->
        <!-- =================================================== -->

        <h2>Asociar platos a un menú</h2>

        <form action="asociar.php" method="get">

            <label for="id">Menú <span class="requerido">*</span></label>
            <select name="id" id="id" required>
                <option value="">Seleccione un menú</option>
                <?php foreach ($menus as $menu) { ?>
                    <option value="<?= $menu['id_menu'] ?>">
                        <?= htmlspecialchars($menu['fecha'] . " — " . (string)$menu['descripcion']) ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit">Continuar</button>

        </form>

        <p><a href="listar.php">Volver al listado de menús</a></p>

    <?php } else { ?>

        <!-- =================================================== -->
        <!-- CON MENÚ SELECCIONADO: mostrar platos y formulario  -->
        <!-- =================================================== -->

        <?php
        $sql_menu = "SELECT id_menu, fecha, descripcion FROM menu WHERE id_menu = :id_menu";
        $stmt_menu = $pdo->prepare($sql_menu);
        $stmt_menu->execute([':id_menu' => $id]);
        $menu = $stmt_menu->fetch();

        if (!$menu) {
            echo '<p class="mensaje error">El menú solicitado no existe.</p>';
            echo '<p><a href="asociar.php">Elegir otro menú</a></p>';
        } else {

            $sql_platos_menu = "SELECT p.id_plato, p.nombre, p.tipo
                                FROM menu_plato mp
                                INNER JOIN plato p ON mp.id_plato = p.id_plato
                                WHERE mp.id_menu = :id_menu
                                ORDER BY p.tipo, p.nombre";

            $stmt_platos_menu = $pdo->prepare($sql_platos_menu);
            $stmt_platos_menu->execute([':id_menu' => $id]);
            $platos_menu = $stmt_platos_menu->fetchAll();

            $todos_los_platos = $pdo->query("SELECT id_plato, nombre, tipo FROM plato ORDER BY tipo, nombre")->fetchAll();
        ?>

        <h2>Asociar platos al menú del <?= htmlspecialchars($menu['fecha']) ?></h2>

        <h3>Platos incluidos en este menú</h3>

        <table>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
            </tr>
            <?php if (empty($platos_menu)) { ?>
            <tr>
                <td colspan="2">Todavía no hay platos asociados a este menú.</td>
            </tr>
            <?php } else { ?>
                <?php foreach ($platos_menu as $plato) { ?>
                <tr>
                    <td><?= htmlspecialchars($plato['nombre']) ?></td>
                    <td><?= htmlspecialchars((string)$plato['tipo']) ?></td>
                </tr>
                <?php } ?>
            <?php } ?>
        </table>

        <h3>Agregar plato al menú</h3>

        <form action="asociar.php?id=<?= $id ?>" method="post">

            <input type="hidden" name="id_menu" value="<?= $id ?>">

            <label for="id_plato">Plato <span class="requerido">*</span></label>
            <select name="id_plato" id="id_plato" required>
                <option value="">Seleccione un plato</option>
                <?php foreach ($todos_los_platos as $plato) { ?>
                    <option value="<?= $plato['id_plato'] ?>">
                        <?= htmlspecialchars($plato['nombre'] . " (" . (string)$plato['tipo'] . ")") ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit">Agregar plato</button>

        </form>

        <p><a href="asociar.php">Elegir otro menú</a> · <a href="listar.php">Volver al listado de menús</a></p>

        <?php } ?>

    <?php } ?>

</main>

</body>
</html>
