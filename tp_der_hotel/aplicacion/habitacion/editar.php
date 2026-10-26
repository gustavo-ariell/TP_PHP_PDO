<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_habitacion = (int)($_POST["id_habitacion"] ?? 0);
    $numero = trim($_POST["numero"] ?? "");
    $piso = $_POST["piso"] ?? "";
    $capacidad = $_POST["capacidad"] ?? "";
    $id_tipo = $_POST["id_tipo"] ?? "";
    $precio_noche = $_POST["precio_noche"] ?? "";

    if ($numero === "" || $piso === "" || $capacidad === "" ||
        $id_tipo === "" || $precio_noche === "") {

        $mensaje = "Debe completar todos los campos obligatorios.";
        $tipo_mensaje = "error";

    } else {

        $sql = "UPDATE habitacion SET
                    numero = :numero,
                    piso = :piso,
                    capacidad = :capacidad,
                    id_tipo = :id_tipo,
                    precio_noche = :precio_noche
                WHERE id_habitacion = :id_habitacion";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':numero'        => $numero,
                ':piso'          => (int)$piso,
                ':capacidad'     => (int)$capacidad,
                ':id_tipo'       => (int)$id_tipo,
                ':precio_noche'  => (float)$precio_noche,
                ':id_habitacion' => $id_habitacion
            ]);

            $mensaje = "Habitación modificada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar la habitación. El número ya existe.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_habitacion"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_habitacion, numero, piso, capacidad, id_tipo, precio_noche
        FROM habitacion WHERE id_habitacion = :id_habitacion";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_habitacion' => $id]);
$habitacion = $stmt->fetch();

if (!$habitacion) {
    die("La habitación solicitada no existe.");
}

$tipos = $pdo->query("SELECT id_tipo, nombre FROM tipo_habitacion ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar habitación</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE GESTIÓN DE HOTEL</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Habitaciones ]</a>
    </nav>
</header>

<main>

    <h2>Modificar habitación</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_habitacion" value="<?= $habitacion['id_habitacion'] ?>">

        <label for="numero">Número <span class="requerido">*</span></label>
        <input type="text" name="numero" id="numero" required
               value="<?= htmlspecialchars($habitacion['numero']) ?>">

        <label for="piso">Piso <span class="requerido">*</span></label>
        <input type="number" name="piso" id="piso" required
               value="<?= $habitacion['piso'] ?>">

        <label for="capacidad">Capacidad <span class="requerido">*</span></label>
        <input type="number" name="capacidad" id="capacidad" min="1" required
               value="<?= $habitacion['capacidad'] ?>">

        <label for="id_tipo">Tipo de habitación <span class="requerido">*</span></label>
        <select name="id_tipo" id="id_tipo" required>
            <?php foreach ($tipos as $tipo) { ?>
                <option value="<?= $tipo['id_tipo'] ?>"
                    <?= $tipo['id_tipo'] == $habitacion['id_tipo'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($tipo['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="precio_noche">Precio por noche <span class="requerido">*</span></label>
        <input type="number" name="precio_noche" id="precio_noche" step="0.01" min="0" required
               value="<?= $habitacion['precio_noche'] ?>">

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>