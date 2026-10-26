<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_vehiculo = (int)($_POST["id_vehiculo"] ?? 0);
    $patente = trim($_POST["patente"] ?? "");
    $marca = trim($_POST["marca"] ?? "");
    $modelo = trim($_POST["modelo"] ?? "");
    $anio = trim($_POST["anio"] ?? "");
    $id_tipo = $_POST["id_tipo"] ?? "";
    $id_cliente = $_POST["id_cliente"] ?? "";

    if ($patente === "" || $marca === "" || $modelo === "" || $id_cliente === "") {
        $mensaje = "Debe completar los campos obligatorios.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE vehiculo SET
                    patente = :patente,
                    marca = :marca,
                    modelo = :modelo,
                    anio = :anio,
                    id_tipo = :id_tipo,
                    id_cliente = :id_cliente
                WHERE id_vehiculo = :id_vehiculo";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':patente'     => $patente,
                ':marca'       => $marca,
                ':modelo'      => $modelo,
                ':anio'        => ($anio === "" ? null : (int)$anio),
                ':id_tipo'     => ($id_tipo === "" ? null : (int)$id_tipo),
                ':id_cliente'  => (int)$id_cliente,
                ':id_vehiculo' => $id_vehiculo
            ]);

            $mensaje = "Vehículo modificado correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar el vehículo. La patente ya existe.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_vehiculo"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_vehiculo, patente, marca, modelo, anio, id_tipo, id_cliente
        FROM vehiculo WHERE id_vehiculo = :id_vehiculo";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_vehiculo' => $id]);
$vehiculo = $stmt->fetch();

if (!$vehiculo) {
    die("El vehículo solicitado no existe.");
}

$tipos = $pdo->query("SELECT id_tipo, nombre FROM tipo_vehiculo ORDER BY nombre")->fetchAll();
$clientes = $pdo->query("SELECT id_cliente, nombre, apellido, dni FROM cliente ORDER BY apellido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar vehículo</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE TALLER MECÁNICO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Vehículos ]</a>
    </nav>
</header>

<main>

    <h2>Modificar información del vehículo</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_vehiculo" value="<?= $vehiculo['id_vehiculo'] ?>">

        <label for="patente">Patente <span class="requerido">*</span></label>
        <input type="text" name="patente" id="patente" required
               value="<?= htmlspecialchars($vehiculo['patente']) ?>">

        <label for="marca">Marca <span class="requerido">*</span></label>
        <input type="text" name="marca" id="marca" required
               value="<?= htmlspecialchars($vehiculo['marca']) ?>">

        <label for="modelo">Modelo <span class="requerido">*</span></label>
        <input type="text" name="modelo" id="modelo" required
               value="<?= htmlspecialchars($vehiculo['modelo']) ?>">

        <label for="anio">Año</label>
        <input type="number" name="anio" id="anio" min="1900" max="2100"
               value="<?= $vehiculo['anio'] !== null ? $vehiculo['anio'] : '' ?>">

        <label for="id_tipo">Tipo de vehículo</label>
        <select name="id_tipo" id="id_tipo">
            <option value="">Seleccione un tipo</option>
            <?php foreach ($tipos as $tipo) { ?>
                <option value="<?= $tipo['id_tipo'] ?>"
                    <?= $tipo['id_tipo'] == $vehiculo['id_tipo'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($tipo['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_cliente">Cliente <span class="requerido">*</span></label>
        <select name="id_cliente" id="id_cliente" required>
            <?php foreach ($clientes as $cliente) { ?>
                <option value="<?= $cliente['id_cliente'] ?>"
                    <?= $cliente['id_cliente'] == $vehiculo['id_cliente'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($cliente['apellido'] . ", " . $cliente['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>