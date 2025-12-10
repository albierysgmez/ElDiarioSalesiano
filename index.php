<?php
session_start();
include("scripts/conexion.php");

// Obtener rol desde la sesión (solo una vez)
$rol = $_SESSION['rol'] ?? "";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Diario Salesiano</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>

    <!-- Variable global para JS externo -->
    <script>
        window.userRol = "<?= $rol ?>";
    </script>

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
            <strong>
                <li><a href="index.php">Inicio</a></li>
            </strong>

            <li><a href="noticia.php">Noticias</a></li>
            <li><a href="laudato.php">Laudato 'Si</a></li>
            <li><a href="about.php">Acerca de</a></li>

            <li id="panel_ctrl">
                <a href="panel_ctrl.php">Panel de control</a>
            </li>
        </ul>
    </nav>

    <!-- HERO PRINCIPAL -->
    <div class="container">
        <div class="left">
            <img src="src/Saint John Don Bosco Colored.png" alt="Ilustración Don Bosco" class="donbosco">
        </div>

        <div class="right">
            <p class="subtitulo">MÁS QUE NOTICIAS, SOMOS LA VOZ DEL PSAC</p>
            <h1 class="titulo">El Diario<br>Salesiano</h1>
            <p class="descripcion">NOTICIAS INTERESANTES</p>
            <div class="flecha">⬇</div>
        </div>
    </div>

    <!-- SLIDER DE NOTICIAS -->
    <main>
        <?php include("scripts/sliders-script.php"); ?>
    </main>


    <footer>
        <p>© 2025 El Diario Salesiano — Todos los derechos reservados</p>
    </footer>


    <!-- Archivo JS externo -->
    <script src="scripts/index.js"></script>

</body>

</html>