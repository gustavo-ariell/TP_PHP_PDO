<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_estudiante = $_POST["id_estudiante"] ?? "";
    $id_menu = $_POST["id_menu"] ?? "";
    $fecha = $_POST["fecha"] ?? "";
    $estado = $_POST["estado"] ?? "";
    $id_forma_pago = $_POST["id_forma_pago"] ?? "";

    if ($id_estudiante === "" || $id_menu === "" || $fecha === "") {
        $mensaje = "Debe seleccionar un estudiante, un menú e ingresar la fecha.";
        $tipo_mensaje = "error";
    } elseif (!in_array($estado, ["pendiente", "confirmada", "cancelada"])) {
        $mensaje = "El estado debe ser pendiente, confirmada o cancelada.";
        $tipo_mensaje = "error";
    } else {

        $sql = "INSERT INTO reserva (id_estudiante, id_menu, fecha, estado, id_forma_pago)
                VALUES (:id_estudiante, :id_menu, :fecha, :estado, :id_forma_pago)";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_estudiante'  => (int)$id_estudiante,
                ':id_menu'        => (int)$id_menu,
                ':fecha'          => $fecha,
                ':estado'         => $estado,
                ':id_forma_pago'  => ($id_forma_pago === "" ? null : (int)$id_forma_pago)
            ]);

            $mensaje = "Reserva realizada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo realizar la reserva.";
            $tipo_mensaje = "error";
        }
    }
}

$estudiantes = $pdo->query("SELECT id_estudiante, nombre, apellido, dni FROM estudiante ORDER BY apellido")->fetchAll();
$menus = $pdo->query("SELECT id_menu, fecha, descripcion FROM menu ORDER BY fecha DESC")->fetchAll();
$formas_pago = $pdo->query("SELECT id_forma_pago, nombre FROM forma_pago ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Realizar reserva</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE COMEDOR UNIVERSITARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Reservas ]</a>
        <a href="alta.php">[ Nueva reserva ]</a>
        <a href="../estudiante/listar.php">[ Estudiantes ]</a>
        <a href="../menu/listar.php">[ Menús ]</a>
    </nav>
</header>

<main>

    <h2>Realizar reserva</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="alta.php" method="post">

        <label for="id_estudiante">Estudiante <span class="requerido">*</span></label>
        <select name="id_estudiante" id="id_estudiante" required>
            <option value="">Seleccione un estudiante</option>
            <?php foreach ($estudiantes as $estudiante) { ?>
                <option value="<?= $estudiante['id_estudiante'] ?>">
                    <?= htmlspecialchars($estudiante['apellido'] . ", " . $estudiante['nombre'] . " (DNI: " . $estudiante['dni'] . ")") ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_menu">Menú <span class="requerido">*</span></label>
        <select name="id_menu" id="id_menu" required>
            <option value="">Seleccione un menú</option>
            <?php foreach ($menus as $menu) { ?>
                <option value="<?= $menu['id_menu'] ?>">
                    <?= htmlspecialchars($menu['fecha'] . " — " . (string)$menu['descripcion']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha">Fecha <span class="requerido">*</span></label>
        <input type="date" name="fecha" id="fecha" required
               value="<?= date('Y-m-d') ?>">

        <label for="estado">Estado <span class="requerido">*</span></label>
        <select name="estado" id="estado" required>
            <option value="pendiente">Pendiente</option>
            <option value="confirmada">Confirmada</option>
            <option value="cancelada">Cancelada</option>
        </select>

        <label for="id_forma_pago">Forma de pago</label>
        <select name="id_forma_pago" id="id_forma_pago">
            <option value="">Seleccione una forma de pago</option>
            <?php foreach ($formas_pago as $forma) { ?>
                <option value="<?= $forma['id_forma_pago'] ?>">
                    <?= htmlspecialchars($forma['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Realizar reserva</button>

    </form>

    <p><a href="listar.php">Volver al listado de reservas</a></p>

</main>

</body>
</html>