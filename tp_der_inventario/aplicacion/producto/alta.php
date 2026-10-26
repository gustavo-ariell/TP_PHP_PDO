<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $codigo = trim($_POST["codigo"] ?? "");
    $nombre = trim($_POST["nombre"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $precio = trim($_POST["precio"] ?? "");
    $stock_actual = trim($_POST["stock_actual"] ?? "0");
    $stock_minimo = trim($_POST["stock_minimo"] ?? "0");
    $id_categoria = $_POST["id_categoria"] ?? "";

    if ($codigo === "" || $nombre === "" || $precio === "") {
        $mensaje = "Debe ingresar código, nombre y precio.";
        $tipo_mensaje = "error";
    } elseif (!is_numeric($precio) || (float)$precio < 0) {
        $mensaje = "El precio debe ser un número mayor o igual a 0.";
        $tipo_mensaje = "error";
    } elseif (!is_numeric($stock_actual) || (int)$stock_actual < 0) {
        $mensaje = "El stock actual debe ser un número mayor o igual a 0.";
        $tipo_mensaje = "error";
    } elseif (!is_numeric($stock_minimo) || (int)$stock_minimo < 0) {
        $mensaje = "El stock mínimo debe ser un número mayor o igual a 0.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO producto (codigo, nombre, descripcion, precio, stock_actual, stock_minimo, id_categoria)
                VALUES (:codigo, :nombre, :descripcion, :precio, :stock_actual, :stock_minimo, :id_categoria)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':codigo'       => $codigo,
                ':nombre'       => $nombre,
                ':descripcion'  => $descripcion,
                ':precio'       => (float)$precio,
                ':stock_actual' => (int)$stock_actual,
                ':stock_minimo' => (int)$stock_minimo,
                ':id_categoria' => ($id_categoria === "" ? null : (int)$id_categoria)
            ]);

            $mensaje = "Producto registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el producto. El código ya existe.";
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
    <h1>SISTEMA DE GESTIÓN DE INVENTARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Productos ]</a>
        <a href="alta.php">[ Nuevo producto ]</a>
        <a href="../categoria/listar.php">[ Categorías ]</a>
        <a href="../proveedor/listar.php">[ Proveedores ]</a>
        <a href="../movimiento/listar.php">[ Movimientos ]</a>
    </nav>
</header>

<main>

    <h2>Registrar producto</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="codigo">Código <span class="requerido">*</span></label>
        <input type="text" name="codigo" id="codigo" required
               value="<?= htmlspecialchars($_POST['codigo'] ?? '') ?>">

        <label for="nombre">Nombre <span class="requerido">*</span></label>
        <input type="text" name="nombre" id="nombre" required
               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>

        <label for="precio">Precio <span class="requerido">*</span></label>
        <input type="number" name="precio" id="precio" step="0.01" min="0" required
               value="<?= htmlspecialchars($_POST['precio'] ?? '') ?>">

        <label for="stock_actual">Stock actual</label>
        <input type="number" name="stock_actual" id="stock_actual" min="0" value="0"
               value="<?= htmlspecialchars($_POST['stock_actual'] ?? '0') ?>">

        <label for="stock_minimo">Stock mínimo</label>
        <input type="number" name="stock_minimo" id="stock_minimo" min="0" value="0"
               value="<?= htmlspecialchars($_POST['stock_minimo'] ?? '0') ?>">

        <label for="id_categoria">Categoría</label>
        <select name="id_categoria" id="id_categoria">
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categorias as $categoria) { ?>
                <option value="<?= $categoria['id_categoria'] ?>"
                    <?= ($_POST['id_categoria'] ?? '') == $categoria['id_categoria'] ? "selected" : "" ?>>
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