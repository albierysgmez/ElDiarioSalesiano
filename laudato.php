<?php include("scripts/conexion.php"); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laudato 'si | El Diario Salesiano</title>
    <link rel="stylesheet" href="styles/noticia.css">
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-left">
        <img src="src/logo-salesianos.png" alt="Logo" class="logo">
        <a href="index.php" class="nav-title">El Diario Salesiano</a>
    </div>

    <div class="hamburger" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <ul class="nav-links" id="navLinks">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="noticia.php">Noticias</a></li>
        <strong><li><a href="../laudato.php">Laudato 'SI</a></li></strong>
        <!-- CORREGIDO: el link about.html -->
        <li><a href="about.php">Acerca de</a></li>
        <li id="panel_ctrl"><a href="panel_crtl.php">Panel de control</a></li>
    </ul>
</nav>

    <!-- contenido principal -->
    <div class="news-container">

    <div class="titulo-sub"> 
        <h1 class="titulo">Noticias Recientes</h1>
        <p class="subtitulo">Descubre las últimas novedades del Deporte en el PSAC</p>
</div>


    <!-- CARDS DE NOTICIAS -->
<div class="cards">
    <?php
    // Mostrar solo noticias del tema LAUDATO 'SI'
    $sql = $conexion->query("
        SELECT * 
        FROM publicacion 
        WHERE tema = 'LAUDATO'
        ORDER BY fecha_publicacion DESC
    ");

    if ($sql && $sql->num_rows > 0) {
        while ($fila = $sql->fetch_assoc()) {
            $img = !empty($fila['imagen']) ? $fila['imagen'] : "src/no-image.png";
            echo '
            <div class="card">
                <img src="' . $img . '" class="card-img" alt="Imagen" onerror="this.src=\'src/no-image.png\'">
                <div class="card-body">
                    <h3>' . htmlspecialchars($fila['titulo']) . '</h3>
                    <span class="tema">' . htmlspecialchars($fila['tema']) . '</span>
                    <p class="descripcion">' . htmlspecialchars($fila['descripcion']) . '</p>
                    <a href="scripts/script_page.php?id=' . $fila['id_publicacion'] . '" class="btn-ver">Leer más</a>
                </div>
            </div>
            ';
        }
    } else {
        echo "<p class='no-news'>No hay noticias de LAUDATO 'SI' disponibles por el momento.</p>";
    }
    ?>
</div>


    <script src="scripts/index.js"></script>

</body>



</html>
