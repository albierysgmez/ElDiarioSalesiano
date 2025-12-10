<?php
include("conexion.php");

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$tema = $_POST['tema'];

$imagen = null;

if (!empty($_FILES['imagen']['name'])) {
    $ruta = "uploads/" . time() . "_" . basename($_FILES['imagen']['name']);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
    $imagen = $ruta;

    $conexion->query("UPDATE publicacion SET imagen='$imagen' WHERE id_publicacion=$id");
}

$sql = "
UPDATE publicacion 
SET titulo='$titulo', descripcion='$descripcion', tema='$tema'
WHERE id_publicacion=$id
";

if ($conexion->query($sql)) {
    header("Location: /panel_ctrl.php");
} else {
    echo "Error: " . $conexion->error;
}

?>
