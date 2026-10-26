<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

// Si viene un id de producto por GET o POST, lo usamos.
$id_producto = (int)($_GET["id"] ?? $_POST["id_producto"] ?? 0);

// --- PROCESAR ASOCIACIÓN ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_proveedor"]) && $id_producto > 0) {

    $id_proveedor = (int)($_POST["id_proveedor"] ?? 0);

    if ($id_proveedor === 0) {
        $mensaje = "Debe seleccionar un proveedor.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO producto_proveedor (id_producto, id_proveedor) VALUES (:id_producto, :id_proveedor)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_producto'  => $id_producto,
                ':id_proveedor' => $id_proveedor
            ]);

            $mensaje = "Proveedor asociado al producto correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo asociar. Puede que ya estén vinculados.";
            $tipo_mensaje = "error";
        }
    }
}

// --- OBTENER TODOS LOS PRODUCTOS (para el selector) ---
$productos = $pdo->query("SELECT id_producto, codigo, nombre FROM producto ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asociar producto con proveedor</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE INVENTARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="../producto/listar.php">[ Productos ]</a>
        <a href="../proveedor/listar.php">[ Proveedores ]</a>
        <a href="asociar.php">[ Asociar ]</a>
        <a href="../movimiento/listar.php">[ Movimientos ]</a>
    </nav>
</header>

<main>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <?php if ($id_producto === 0) { ?>

        <!-- SIN PRODUCTO SELECCIONADO: selector -->
        <h2>Asociar producto con proveedor</h2>

        <form action="asociar.php" method="get">

            <label for="id">Producto <span class="requerido">*</span></label>
            <select name="id" id="id" required>
                <option value="">Seleccione un producto</option>
                <?php foreach ($productos as $prod) { ?>
                    <option value="<?= $prod['id_producto'] ?>">
                        <?= htmlspecialchars($prod['codigo'] . " — " . $prod['nombre']) ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit">Continuar</button>

        </form>

    <?php } else { ?>

        <?php
        $sql_prod = "SELECT id_producto, codigo, nombre FROM producto WHERE id_producto = :id_producto";
        $stmt_prod = $pdo->prepare($sql_prod);
        $stmt_prod->execute([':id_producto' => $id_producto]);
        $producto = $stmt_prod->fetch();

        if (!$producto) {

            echo '<p class="mensaje error">El producto solicitado no existe.</p>';
            echo '<p><a href="asociar.php">Elegir otro producto</a></p>';

        } else {

            $sql_prov_prod = "SELECT p.id_proveedor, p.nombre, p.contacto, p.telefono, p.email
                              FROM producto_proveedor pp
                              INNER JOIN proveedor p ON pp.id_proveedor = p.id_proveedor
                              WHERE pp.id_producto = :id_producto
                              ORDER BY p.nombre";

            $stmt_prov_prod = $pdo->prepare($sql_prov_prod);
            $stmt_prov_prod->execute([':id_producto' => $id_producto]);
            $proveedores_producto = $stmt_prov_prod->fetchAll();

            $todos_proveedores = $pdo->query("SELECT id_proveedor, nombre FROM proveedor ORDER BY nombre")->fetchAll();
        ?>

        <h2>Asociar proveedores al producto: <?= htmlspecialchars($producto['nombre']) ?></h2>

        <h3>Proveedores vinculados a este producto</h3>

        <table>
            <tr>
                <th>Nombre</th>
                <th>Contacto</th>
                <th>Teléfono</th>
                <th>Correo</th>
            </tr>
            <?php if (empty($proveedores_producto)) { ?>
            <tr>
                <td colspan="4">Todavía no hay proveedores asociados a este producto.</td>
            </tr>
            <?php } else { ?>
                <?php foreach ($proveedores_producto as $prov) { ?>
                <tr>
                    <td><?= htmlspecialchars($prov['nombre']) ?></td>
                    <td><?= htmlspecialchars((string)$prov['contacto']) ?></td>
                    <td><?= htmlspecialchars((string)$prov['telefono']) ?></td>
                    <td><?= htmlspecialchars((string)$prov['email']) ?></td>
                </tr>
                <?php } ?>
            <?php } ?>
        </table>

        <h3>Agregar proveedor al producto</h3>

        <form action="asociar.php?id=<?= $id_producto ?>" method="post">

            <input type="hidden" name="id_producto" value="<?= $id_producto ?>">

            <label for="id_proveedor">Proveedor <span class="requerido">*</span></label>
            <select name="id_proveedor" id="id_proveedor" required>
                <option value="">Seleccione un proveedor</option>
                <?php foreach ($todos_proveedores as $prov) { ?>
                    <option value="<?= $prov['id_proveedor'] ?>">
                        <?= htmlspecialchars($prov['nombre']) ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit">Agregar proveedor</button>

        </form>

        <p><a href="asociar.php">Elegir otro producto</a></p>

        <?php } ?>

    <?php } ?>

</main>

</body>
</html>