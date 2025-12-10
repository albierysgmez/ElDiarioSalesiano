<?php
session_start();

// ❌ TENÍAS: require_once "/scripts/conexion.php";
// ✔ ARREGLADO:
require_once "scripts/conexion.php";

// Validar ID
if (!isset($_GET['id'])) {
    die("No se recibió ID.");
}

$id = intval($_GET['id']);

$stmt = $conexion->prepare("SELECT * FROM publicacion WHERE id_publicacion = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

$pub = $res->fetch_assoc();

if (!$pub) {
    die("Publicación no encontrada.");
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Publicación</title>

    <!-- CSS GENERAL -->
    <link rel="stylesheet" href="styles/editar.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-left">
        <img src="src/logo-salesianos.png" alt="Logo" class="logo">
        <a href="index.php" class="nav-title">El Diario Salesiano</a>
    </div>

    <div class="hamburger" onclick="toggleMenu()">
        <span></span><span></span><span></span>
    </div>

    <ul class="nav-links" id="navLinks">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="noticia.php">Noticias</a></li>
        <li><a href="laudato.php">Laudato 'SI</a></li>
        <li><a href="about.php">Acerca de</a></li>
        <li id="panel_ctrl"><a href="panel_ctrl.php">Panel de control</a></li>
    </ul>
</nav>

<div class="form-container">

<h2>Editar Publicación</h2>

<form action="scripts/actualizar_publicacion.php" method="POST" enctype="multipart/form-data">
    
    <input type="hidden" name="id" value="<?php echo $pub['id_publicacion']; ?>">

    <label>Título:</label>
    <input type="text" name="titulo" value="<?php echo htmlspecialchars($pub['titulo']); ?>" required>

    <label>Descripción:</label>
    <textarea name="descripcion" required><?php echo htmlspecialchars($pub['descripcion']); ?></textarea>

    <label>Tema:</label>
    <select name="tema" required>
        <?php 
        $temas = [
            "GENERAL",
            "INFORMATICA",
            "PROMOCION",
            "CONTABILIDAD",
            "TURISMO",
            "MERCADEO",
            "ACONDICIONAMIENTO FISICO",
            "PASTORAL",
            "LAUDATO",
            "ARTE"
        ];

        foreach ($temas as $t) {
            $selected = ($pub['tema'] == $t) ? "selected" : "";
            echo "<option value='$t' $selected>$t</option>";
        }
        ?>
    </select>

    <!-- Imagen actual -->
    <label>Imagen actual:</label>
    <?php if (!empty($pub['imagen'])): ?>
        <img src="uploads/<?php echo basename($pub['imagen']); ?>" width="200" class="preview">
    <?php else: ?>
        <p>No hay imagen</p>
    <?php endif; ?>

    <!-- Video actual -->
    <label>Video actual:</label>
    <?php if (!empty($pub['video'])): ?>
        <video width="300" controls class="preview">
            <source src="uploads/<?php echo basename($pub['video']); ?>" type="video/mp4">
        </video>
    <?php else: ?>
        <p>No hay video</p>
    <?php endif; ?>

    <!-- Nuevos archivos opcionales -->
    <label>Nueva imagen (opcional):</label>
    <input type="file" name="imagen" accept="image/*">

    <label>Nuevo video (opcional):</label>
    <input type="file" name="video" accept="video/mp4,video/webm,video/ogg">

    <button type="submit">Actualizar</button>

</form>

</div>

<footer>
    <p>© 2025 El Diario Salesiano — Todos los derechos reservados</p>
</footer>

<script src="scripts/index.js"></script>

</body>
</html>
