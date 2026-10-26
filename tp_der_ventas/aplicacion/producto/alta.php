<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $precio = $_POST["precio"] ?? "";
    $stock = $_POST["stock"] ?? "";
    $id_categoria = $_POST["id_categoria"] ?? "";

    if ($nombre === "" || $precio === "" || $stock === "") {

        $mensaje = "Debe ingresar un nombre, un precio y el stock.";
        $tipo_mensaje = "error";

    } elseif (!is_numeric($precio) || (float)$precio < 0) {

        $mensaje = "El precio debe ser un número válido.";
        $tipo_mensaje = "error";

    } elseif (!is_numeric($stock) || (int)$stock < 0) {

        $mensaje = "El stock debe ser un número mayor o igual a 0.";
        $tipo_mensaje = "error";

    } else {

        $sql = "INSERT INTO producto
                    (nombre, descripcion, precio, stock, id_categoria)
                VALUES
                    (:nombre, :descripcion, :precio, :stock, :id_categoria)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'       => $nombre,
                ':descripcion'  => $descripcion,
                ':precio'       => (float)$precio,
                ':stock'        => (int)$stock,
                ':id_categoria' => ($id_categoria === "" ? null : (int)$id_categoria)
            ]);

            $mensaje = "Producto registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el producto.";
            $tipo_mensaje = "error";
        }
    }
}

$categorias = $pdo->query("SELECT id_categoria, nombre FROM categoria ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar producto</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE VENTAS DE LIBRERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Productos ]</a>
        <a href="alta.php">[ Nuevo producto ]</a>
        <a href="../cliente/listar.php">[ Clientes ]</a>
        <a href="../vendedor/listar.php">[ Vendedores ]</a>
        <a href="../venta/listar.php">[ Ventas ]</a>
    </nav>
</header>

<main>

    <h2>Registrar producto</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>

        <label for="precio">Precio <span class="requerido">*</span></label>
        <input type="number" name="precio" id="precio" step="0.01" min="0" required
               value="<?= htmlspecialchars($_POST['precio'] ?? '') ?>">

        <label for="stock">Stock <span class="requerido">*</span></label>
        <input type="number" name="stock" id="stock" min="0" required
               value="<?= htmlspecialchars($_POST['stock'] ?? '0') ?>">

        <label for="id_categoria">Categoría</label>
        <select name="id_categoria" id="id_categoria">
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categorias as $categoria) { ?>
                <option value="<?= $categoria['id_categoria'] ?>">
                    <?= htmlspecialchars($categoria['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Registrar producto</button>

    </form>

    <p><a href="listar.php">Volver al listado de productos</a></p>

</main>

</body>
</html>