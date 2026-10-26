<?php
require_once "../conexion.php";

// Recibir parámetros por GET o POST
$id_detalle = $_REQUEST["id"] ?? "";
$id_pedido  = $_REQUEST["pedido"] ?? "";

// Validación de parámetros
if ($id_detalle === "" || !ctype_digit($id_detalle) ||
    $id_pedido  === "" || !ctype_digit($id_pedido)) {
    header("Location: listar.php");
    exit;
}

try {

    // Verificar que el detalle pertenezca al pedido
    $check = $pdo->prepare("SELECT id_detalle FROM detalle_pedido
                            WHERE id_detalle = :id_detalle AND id_pedido = :id_pedido");
    $check->execute([
        ':id_detalle' => (int)$id_detalle,
        ':id_pedido'  => (int)$id_pedido
    ]);

    if (!$check->fetch()) {
        header("Location: agregar.php?id=" . (int)$id_pedido);
        exit;
    }

    // Eliminar el detalle
    $sql = "DELETE FROM detalle_pedido
            WHERE id_detalle = :id_detalle AND id_pedido = :id_pedido";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_detalle' => (int)$id_detalle,
        ':id_pedido'  => (int)$id_pedido
    ]);

} catch (PDOException $e) {
    // En caso de error, redirigir igualmente
}

header("Location: agregar.php?id=" . (int)$id_pedido);
exit;
?>
