<?php
include("conexion.php");

// Recibir datos del formulario
$titulo = $_POST['titulo'] ?? null;
$descripcion = $_POST['descripcion'] ?? null;
$tema = $_POST['tema'] ?? null;

$imagen = null;
$video = null;

if (!$titulo || !$descripcion || !$tema) {
    die("❌ Error: Faltan datos obligatorios.");
}

// Carpeta correcta según tu estructura
$uploads_dir = "../uploads";  

if (!is_dir($uploads_dir)) {
    mkdir($uploads_dir, 0777, true);
}

// --------------------
// SUBIR IMAGEN (opcional)
// --------------------
if (!empty($_FILES['imagen']['name'])) {

    $nombre_imagen = time() . "_" . preg_replace("/[^A-Za-z0-9.\-_]/", "", $_FILES['imagen']['name']);
    $ruta = "$uploads_dir/$nombre_imagen";

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
        // Guardar en BD como: uploads/archivo.png  (sin ../)
        $imagen = "uploads/" . $nombre_imagen;
    } else {
        die("❌ Error: No se pudo subir la imagen.");
    }
}

// --------------------
// SUBIR VIDEO (opcional)
// --------------------
if (!empty($_FILES['video']['name'])) {

    $nombre_video = time() . "_" . preg_replace("/[^A-Za-z0-9.\-_]/", "", $_FILES['video']['name']);
    $ruta_video = "$uploads_dir/$nombre_video";

    $tipos_permitidos = ['video/mp4', 'video/webm', 'video/ogg'];
    if (!in_array($_FILES['video']['type'], $tipos_permitidos)) {
        die("❌ Error: Solo se permiten videos MP4, WEBM u OGG.");
    }

    if (move_uploaded_file($_FILES['video']['tmp_name'], $ruta_video)) {
        $video = "uploads/" . $nombre_video; // Guardar limpio
    } else {
        die("❌ Error: No se pudo subir el video.");
    }
}

// --------------------
// INSERTAR EN BD
// --------------------
$stmt = $conexion->prepare("
    INSERT INTO publicacion (titulo, descripcion, imagen, tema, video)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param("sssss", $titulo, $descripcion, $imagen, $tema, $video);

if ($stmt->execute()) {
    $id_publicacion = $stmt->insert_id;
    header("Location: script_page.php?id=" . $id_publicacion);
    exit;
} else {
    die("❌ Error SQL: " . $stmt->error);
}
?>
