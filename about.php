<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros – El Diario Salesiano</title>
    <link rel="stylesheet" href="styles/about.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            <li><a href="../laudato.php">Laudato 'SI</a></li>
            <!-- CORREGIDO: el link about.html -->
            <li><a href="about.php">Acerca de</a></li>
            <li id="panel_ctrl"><a href="mostrar_publicacion.php">Panel de control</a></li>
        </ul>
    </nav>

    <main>
        <div class="about-container">

            <div class="text">
                <h2>Sobre Nosotros</h2>
                <p>
                    El Diario Salesiano es un proyecto escolar destinado a informar, comunicar y
                    documentar las actividades más importantes de nuestra comunidad educativa.
                </p>

                <p>
                    Nuestro objetivo es fortalecer los valores salesianos, mantener un registro histórico
                    del colegio y ofrecer un espacio donde los estudiantes puedan expresarse, aprender
                    y desarrollar habilidades periodísticas y digitales.
                </p>

                <p>
                    Inspirados en San Juan Bosco, buscamos promover la verdad, la alegría y el respeto.
                </p>

                <div id="iconos">
                    <!-- Instagram -->
                    <p>
                        <i class="fa-brands fa-instagram"></i> <a href="https://www.instagram.com/psac_moca_sdb/?__pwa=1">@psac_moca_sdb</a>
                    </p>

                    <!-- Telefono -->
                    <p>
                        <i class="fa-solid fa-phone"></i> (809) 823-3322
                    </p>
                </div>

            </div>

            <div class="image">
                <img src="src/Saint John Don Bosco Colored.png" alt="Don Bosco">
            </div>

        </div>
    </main>

    <section class="team">
        <h2>Nuestro Equipo</h2>
        <div class="profiles">

            <div class="profile">
                <div class="photo"><img src="" alt=""></div>
                <p>Albierys Gómez</p>
            </div>

            <div class="profile">
                <div class="photo"></div>
                <p>Stancy Sánchez</p>
            </div>

            <div class="profile">
                <div class="photo"></div>
                <p>Adaury Paulino</p>
            </div>

        </div>
    </section>


    <footer>
        <p>© 2025 El Diario Salesiano — Todos los derechos reservados</p>
    </footer>

    <script src="scripts/index.js"></script>
</body>

</html>