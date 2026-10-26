<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_producto = (int)($_POST["id_producto"] ?? 0);
    $nombre = trim($_POST["nombre"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $precio = $_POST["precio"] ?? "";
    $stock = $_POST["stock"] ?? "";
    $id_categoria = $_POST["id_categoria"] ?? "";

    if ($nombre === "" || $precio === "" || $stock === "") {
        $mensaje = "Debe completar todos los campos obligatorios.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE producto SET
                    nombre = :nombre,
                    descripcion = :descripcion,
                    precio = :precio,
                    stock = :stock,
                    id_categoria = :id_categoria
                WHERE id_producto = :id_producto";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'        => $nombre,
                ':descripcion'   => $descripcion,
                ':precio'        => (float)$precio,
                ':stock'         => (int)$stock,
                ':id_categoria'  => ($id_categoria === "" ? null : (int)$id_categoria),
                ':id_producto'   => $id_producto
            ]);

            $mensaje = "Producto modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el producto.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_producto"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_producto, nombre, descripcion, precio, stock, id_categoria
        FROM producto
        WHERE id_producto = :id_producto";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_producto' => $id]);
$producto = $stmt->fetch();

if (!$producto) {
    die("El producto solicitado no existe.");
}

$categorias = $pdo->query("SELECT id_categoria, nombre FROM categoria ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar producto</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE VENTAS DE LIBRERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Productos ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del producto</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($producto['nombre']) ?>">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3"><?= htmlspecialchars((string)$producto['descripcion']) ?></textarea>

        <label for="precio">Precio <span class="requerido">*</span></label>
        <input type="number" name="precio" id="precio" step="0.01" min="0" required
               value="<?= $producto['precio'] ?>">

        <label for="stock">Stock <span class="requerido">*</span></label>
        <input type="number" name="stock" id="stock" min="0" required
               value="<?= $producto['stock'] ?>">

        <label for="id_categoria">Categoría</label>
        <select name="id_categoria" id="id_categoria">
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categorias as $categoria) { ?>
                <option value="<?= $categoria['id_categoria'] ?>"
                    <?= $categoria['id_categoria'] == $producto['id_categoria'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($categoria['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>