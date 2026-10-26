<?php
require_once "../conexion.php";

$id_articulo = $_REQUEST["id_articulo"] ?? "";
$id_autor    = $_REQUEST["id_autor"] ?? "";

if (ctype_digit($id_articulo) && ctype_digit($id_autor)) {

    try {
        $stmt = $pdo->prepare("DELETE FROM articulo_autor
                               WHERE id_articulo = :id_articulo AND id_autor = :id_autor");
        $stmt->execute([
            ':id_articulo' => (int)$id_articulo,
            ':id_autor'    => (int)$id_autor
        ]);
    } catch (PDOException $e) {
        // Silenciar
    }
}

header("Location: asociar_autor.php");
exit;
?>