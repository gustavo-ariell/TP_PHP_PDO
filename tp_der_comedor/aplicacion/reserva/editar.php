<?php
require_once "../conexion.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_reserva = (int)($_POST["id_reserva"] ?? 0);
    $id_estudiante = $_POST["id_estudiante"] ?? "";
    $id_menu = $_POST["id_menu"] ?? "";
    $fecha = $_POST["fecha"] ?? "";
    $estado = $_POST["estado"] ?? "";
    $id_forma_pago = $_POST["id_forma_pago"] ?? "";

    if ($id_estudiante === "" || $id_menu === "" || $fecha === "") {
        $mensaje = "Debe completar todos los campos obligatorios.";
        $tipo_mensaje = "error";
    } elseif (!in_array($estado, ["pendiente", "confirmada", "cancelada"])) {
        $mensaje = "El estado debe ser pendiente, confirmada o cancelada.";
        $tipo_mensaje = "error";
    } else {

        $sql = "UPDATE reserva SET
                    id_estudiante = :id_estudiante,
                    id_menu = :id_menu,
                    fecha = :fecha,
                    estado = :estado,
                    id_forma_pago = :id_forma_pago
                WHERE id_reserva = :id_reserva";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_estudiante'  => (int)$id_estudiante,
                ':id_menu'        => (int)$id_menu,
                ':fecha'          => $fecha,
                ':estado'         => $estado,
                ':id_forma_pago'  => ($id_forma_pago === "" ? null : (int)$id_forma_pago),
                ':id_reserva'     => $id_reserva
            ]);

            $mensaje = "Reserva modificada correctamente.";
            $tipo_mensaje = "exito";

        } catch (PDOException $e) {
            $mensaje = "No se pudo modificar la reserva.";
            $tipo_mensaje = "error";
        }
    }
}

$id = (int)($_POST["id_reserva"] ?? $_GET["id"] ?? 0);

$sql = "SELECT id_reserva, id_estudiante, id_menu, fecha, estado, id_forma_pago
        FROM reserva WHERE id_reserva = :id_reserva";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_reserva' => $id]);
$reserva = $stmt->fetch();

if (!$reserva) {
    die("La reserva solicitada no existe.");
}

$estudiantes = $pdo->query("SELECT id_estudiante, nombre, apellido, dni FROM estudiante ORDER BY apellido")->fetchAll();
$menus = $pdo->query("SELECT id_menu, fecha, descripcion FROM menu ORDER BY fecha DESC")->fetchAll();
$formas_pago = $pdo->query("SELECT id_forma_pago, nombre FROM forma_pago ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar reserva</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<header>
    <h1>SISTEMA DE COMEDOR UNIVERSITARIO</h1>
    <nav>
        <a href="../index.php">[ Inicio ]</a>
        <a href="listar.php">[ Reservas ]</a>
    </nav>
</header>

<main>

    <h2>Modificar reserva</h2>

    <?php if ($mensaje !== "") { ?>
        <div class="mensaje <?= $tipo_mensaje ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php } ?>

    <form action="editar.php" method="post">

        <input type="hidden" name="id_reserva" value="<?= $reserva['id_reserva'] ?>">

        <label for="id_estudiante">Estudiante <span class="requerido">*</span></label>
        <select name="id_estudiante" id="id_estudiante" required>
            <?php foreach ($estudiantes as $estudiante) { ?>
                <option value="<?= $estudiante['id_estudiante'] ?>"
                    <?= $estudiante['id_estudiante'] == $reserva['id_estudiante'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($estudiante['apellido'] . ", " . $estudiante['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_menu">Menú <span class="requerido">*</span></label>
        <select name="id_menu" id="id_menu" required>
            <?php foreach ($menus as $menu) { ?>
                <option value="<?= $menu['id_menu'] ?>"
                    <?= $menu['id_menu'] == $reserva['id_menu'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($menu['fecha'] . " — " . (string)$menu['descripcion']) ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha">Fecha <span class="requerido">*</span></label>
        <input type="date" name="fecha" id="fecha" required
               value="<?= htmlspecialchars($reserva['fecha']) ?>">

        <label for="estado">Estado <span class="requerido">*</span></label>
        <select name="estado" id="estado" required>
            <option value="pendiente" <?= $reserva['estado'] === 'pendiente' ? "selected" : "" ?>>Pendiente</option>
            <option value="confirmada" <?= $reserva['estado'] === 'confirmada' ? "selected" : "" ?>>Confirmada</option>
            <option value="cancelada" <?= $reserva['estado'] === 'cancelada' ? "selected" : "" ?>>Cancelada</option>
        </select>

        <label for="id_forma_pago">Forma de pago</label>
        <select name="id_forma_pago" id="id_forma_pago">
            <option value="">Seleccione una forma de pago</option>
            <?php foreach ($formas_pago as $forma) { ?>
                <option value="<?= $forma['id_forma_pago'] ?>"
                    <?= $forma['id_forma_pago'] == $reserva['id_forma_pago'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($forma['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="listar.php">Volver al listado</a></p>

</main>

</body>
</html>