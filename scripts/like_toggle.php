<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id_usuario"])) {
    echo json_encode(["error" => "not_logged"]);
    exit;
}

$id_usuario = intval($_SESSION["id_usuario"]);
$id_publicacion = intval($_POST["id_publicacion"]);

if (!$id_publicacion) {
    echo json_encode(["error" => "no_id"]);
    exit;
}

// ¿Ya existe like?
$q = $conexion->query("
    SELECT id_like FROM likes
    WHERE id_usuario = $id_usuario AND id_publicacion = $id_publicacion
");

if ($q->num_rows > 0) {
    // ❌ Quitar like
    $conexion->query("
        DELETE FROM likes
        WHERE id_usuario = $id_usuario AND id_publicacion = $id_publicacion
    ");
    $status = "removed";
} else {
    // ❤️ Dar like
    $conexion->query("
        INSERT INTO likes (id_usuario, id_publicacion)
        VALUES ($id_usuario, $id_publicacion)
    ");
    $status = "added";
}

// total actualizado
$total = $conexion->query("
    SELECT COUNT(*) AS total FROM likes WHERE id_publicacion = $id_publicacion
")->fetch_assoc()["total"];

echo json_encode([
    "status" => $status,
    "total" => $total
]);
?>
