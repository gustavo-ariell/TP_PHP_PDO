<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $patente = trim($_POST["patente"] ?? "");
    $marca = trim($_POST["marca"] ?? "");
    $modelo = trim($_POST["modelo"] ?? "");
    $anio = trim($_POST["anio"] ?? "");
    $id_tipo = $_POST["id_tipo"] ?? "";
    $id_cliente = $_POST["id_cliente"] ?? "";

    if ($patente === "" || $marca === "" || $modelo === "" || $id_cliente === "") {
        $mensaje = "Debe ingresar patente, marca, modelo y seleccionar un cliente.";
        $tipo_mensaje = "error";
    } elseif ($anio !== "" && (!is_numeric($anio) || (int)$anio < 1900 || (int)$anio > 2100)) {
        $mensaje = "El año debe ser un número válido entre 1900 y 2100.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO vehiculo (patente, marca, modelo, anio, id_tipo, id_cliente)
                VALUES (:patente, :marca, :modelo, :anio, :id_tipo, :id_cliente)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':patente'    => $patente,
                ':marca'      => $marca,
                ':modelo'     => $modelo,
                ':anio'       => ($anio === "" ? null : (int)$anio),
                ':id_tipo'    => ($id_tipo === "" ? null : (int)$id_tipo),
                ':id_cliente' => (int)$id_cliente
            ]);

            $mensaje = "Vehículo registrado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar el vehículo. La patente ya existe.";
            $tipo_mensaje = "error";
        }
    }
}

$tipos = $pdo->query("SELECT id_tipo, nombre FROM tipo_vehiculo ORDER BY nombre")->fetchAll();
$clientes = $pdo->query("SELECT id_cliente, nombre, apellido, dni FROM cliente ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar vehículo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Vehículos ]</a>
        <a href="alta.php">[ Nuevo vehículo ]</a>
        <a href="../cliente/listar.php">[ Clientes ]</a>
        <a href="../reparacion/listar.php">[ Reparaciones ]</a>
    </nav>
</header>

<main>

    <h2>Registrar vehículo</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="patente">Patente <span class="requerido">*</span></label>
        <input type="text" name="patente" id="patente" required
               value="<?= htmlspecialchars($_POST['patente'] ?? '') ?>">

        <label for="marca">Marca <span class="requerido">*</span></label>
        <input type="text" name="marca" id="marca" required
               value="<?= htmlspecialchars($_POST['marca'] ?? '') ?>">

        <label for="modelo">Modelo <span class="requerido">*</span></label>
        <input type="text" name="modelo" id="modelo" required
               value="<?= htmlspecialchars($_POST['modelo'] ?? '') ?>">

        <label for="anio">Año</label>
        <input type="number" name="anio" id="anio" min="1900" max="2100"
               value="<?= htmlspecialchars($_POST['anio'] ?? '') ?>">

        <label for="id_tipo">Tipo de vehículo</label>
        <select name="id_tipo" id="id_tipo">
            <option value="">Seleccione un tipo</option>
            <?php foreach ($tipos as $tipo) { ?>
                <option value="<?= $tipo['id_tipo'] ?>"
                    <?= ($_POST['id_tipo'] ?? '') == $tipo['id_tipo'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($tipo['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_cliente">Cliente <span class="requerido">*</span></label>
        <select name="id_cliente" id="id_cliente" required>
            <option value="">Seleccione un cliente</option>
            <?php foreach ($clientes as $cliente) { ?>
                <option value="<?= $cliente['id_cliente'] ?>">
                    <?= htmlspecialchars($cliente['apellido'] . ", " . $cliente['nombre'] . " (DNI: " . $cliente['dni'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Registrar vehículo</button>

    </form>

    <p><a href="listar.php">Volver al listado de vehículos</a></p>

</main>

</body>
</html>