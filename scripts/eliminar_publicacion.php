<?php
include("conexion.php");

if (!isset($_GET['id'])) {
    die("ID no recibido.");
}

$id = intval($_GET['id']); // Seguridad

// 1️⃣ ELIMINAR LIKES RELACIONADOS
$conexion->query("DELETE FROM likes WHERE id_publicacion = $id");

// 2️⃣ ELIMINAR COMENTARIOS RELACIONADOS
$conexion->query("DELETE FROM comentarios WHERE id_publicacion = $id");

// 3️⃣ ELIMINAR LA PUBLICACIÓN
$conexion->query("DELETE FROM publicacion WHERE id_publicacion = $id");

// 4️⃣ REDIRIGIR A NOTICIAS
header("Location: ../panel_ctrl.php");
exit();
?>
