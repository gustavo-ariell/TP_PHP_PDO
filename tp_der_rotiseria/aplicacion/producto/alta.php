<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre       = trim($_POST["nombre"] ?? "");
    $descripcion  = trim($_POST["descripcion"] ?? "");
    $precio       = trim($_POST["precio"] ?? "");
    $id_categoria = $_POST["id_categoria"] ?? "";

    if ($nombre === "" || $precio === "") {
        $mensaje = "Debe ingresar el nombre y el precio del producto.";
        $tipo_mensaje = "error";
    } elseif (!is_numeric($precio) || (float)$precio <= 0) {
        $mensaje = "El precio debe ser un número mayor que cero.";
        $tipo_mensaje = "error";
    } elseif ($id_categoria === "" || !ctype_digit($id_categoria)) {
        $mensaje = "Debe seleccionar una categoría.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO producto
                    (nombre, descripcion, precio, id_categoria)
                VALUES
                    (:nombre, :descripcion, :precio, :id_categoria)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nombre'       => $nombre,
                ':descripcion'  => $descripcion,
                ':precio'       => (float)$precio,
                ':id_categoria' => (int)$id_categoria
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
    <h1>SISTEMA DE GESTIÓN DE PEDIDOS — ROTISERÍA</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Productos ]</a>
        <a href="alta.php">[ Nuevo producto ]</a>
        <a href="../pedido/listar.php">[ Pedidos ]</a>
        <a href="../cliente/listar.php">[ Clientes ]</a>
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

        <label for="id_categoria">Categoría <span class="requerido">*</span></label>
        <select name="id_categoria" id="id_categoria" required>
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categorias as $categoria) { ?>
                <option value="<?= $categoria['id_categoria'] ?>"
                    <?= (isset($_POST['id_categoria']) && $_POST['id_categoria'] == $categoria['id_categoria']) ? 'selected' : '' ?>>
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
