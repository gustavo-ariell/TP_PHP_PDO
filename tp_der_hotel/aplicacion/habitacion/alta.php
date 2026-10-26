<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $numero = trim($_POST["numero"] ?? "");
    $piso = $_POST["piso"] ?? "";
    $capacidad = $_POST["capacidad"] ?? "";
    $id_tipo = $_POST["id_tipo"] ?? "";
    $precio_noche = $_POST["precio_noche"] ?? "";

    if ($numero === "" || $piso === "" || $capacidad === "" ||
        $id_tipo === "" || $precio_noche === "") {

        $mensaje = "Debe completar todos los campos obligatorios.";
        $tipo_mensaje = "error";

    } elseif (!is_numeric($piso)) {

        $mensaje = "El piso debe ser un número válido.";
        $tipo_mensaje = "error";

    } elseif (!is_numeric($capacidad) || (int)$capacidad < 1) {

        $mensaje = "La capacidad debe ser un número mayor o igual a 1.";
        $tipo_mensaje = "error";

    } elseif (!is_numeric($precio_noche) || (float)$precio_noche < 0) {

        $mensaje = "El precio por noche debe ser un número válido.";
        $tipo_mensaje = "error";

    } else {

        $sql = "INSERT INTO habitacion (numero, piso, capacidad, id_tipo, precio_noche)
                VALUES (:numero, :piso, :capacidad, :id_tipo, :precio_noche)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':numero'       => $numero,
                ':piso'         => (int)$piso,
                ':capacidad'    => (int)$capacidad,
                ':id_tipo'      => (int)$id_tipo,
                ':precio_noche' => (float)$precio_noche
            ]);

            $mensaje = "Habitación registrada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo registrar la habitación. El número ya existe.";
            $tipo_mensaje = "error";
        }
    }
}

$tipos = $pdo->query("SELECT id_tipo, nombre FROM tipo_habitacion ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar habitación</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Habitaciones ]</a>
        <a href="alta.php">[ Nueva habitación ]</a>
        <a href="../huesped/listar.php">[ Huéspedes ]</a>
        <a href="../reserva/listar.php">[ Reservas ]</a>
    </nav>
</header>

<main>

    <h2>Registrar habitación</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="numero">Número <span class="requerido">*</span></label>
        <input type="text" name="numero" id="numero" required
               value="<?= htmlspecialchars($_POST['numero'] ?? '') ?>">

        <label for="piso">Piso <span class="requerido">*</span></label>
        <input type="number" name="piso" id="piso" required
               value="<?= htmlspecialchars($_POST['piso'] ?? '') ?>">

        <label for="capacidad">Capacidad <span class="requerido">*</span></label>
        <input type="number" name="capacidad" id="capacidad" min="1" required
               value="<?= htmlspecialchars($_POST['capacidad'] ?? '1') ?>">

        <label for="id_tipo">Tipo de habitación <span class="requerido">*</span></label>
        <select name="id_tipo" id="id_tipo" required>
            <option value="">Seleccione un tipo</option>
            <?php foreach ($tipos as $tipo) { ?>
                <option value="<?= $tipo['id_tipo'] ?>">
                    <?= htmlspecialchars($tipo['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="precio_noche">Precio por noche <span class="requerido">*</span></label>
        <input type="number" name="precio_noche" id="precio_noche" step="0.01" min="0" required
               value="<?= htmlspecialchars($_POST['precio_noche'] ?? '') ?>">

        <button type="submit">Registrar habitación</button>

    </form>

    <p><a href="listar.php">Volver al listado de habitaciones</a></p>

</main>

</body>
</html>