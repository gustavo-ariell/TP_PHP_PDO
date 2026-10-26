<?php
require_once "../conexion.php";

$id_detalle   = $_REQUEST["id"] ?? "";
$id_prestamo  = $_REQUEST["prestamo"] ?? "";

if ($id_detalle === "" || !ctype_digit($id_detalle) ||
    $id_prestamo === "" || !ctype_digit($id_prestamo)) {
    header("Location: listar.php");
    exit;
}

try {

    // Obtener id_herramienta antes de eliminar
    $sql = "SELECT id_herramienta FROM detalle_prestamo
            WHERE id_detalle = :id_detalle AND id_prestamo = :id_prestamo";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_detalle'  => (int)$id_detalle,
        ':id_prestamo' => (int)$id_prestamo
    ]);

    $det = $stmt->fetch();

    if ($det) {

        // Eliminar del detalle
        $del = $pdo->prepare("DELETE FROM detalle_prestamo
                              WHERE id_detalle = :id_detalle AND id_prestamo = :id_prestamo");
        $del->execute([
            ':id_detalle'  => (int)$id_detalle,
            ':id_prestamo' => (int)$id_prestamo
        ]);

        // Devolver herramienta a disponible
        $upd = $pdo->prepare("UPDATE herramienta SET estado = 'disponible' WHERE id_herramienta = :id");
        $upd->execute([':id' => (int)$det["id_herramienta"]]);
    }

} catch (PDOException $e) {
    // Silenciar
}

header("Location: agregar_herramienta.php?id=" . (int)$id_prestamo);
exit;
?>