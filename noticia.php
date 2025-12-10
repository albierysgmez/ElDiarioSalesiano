<?php include("scripts/conexion.php"); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias | El Diario Salesiano</title>
    <link rel="stylesheet" href="styles/noticia.css">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-left">
            <img src="src/logo-salesianos.png" alt="Logo" class="logo">
            <a href="index.php" class="nav-title">El Diario Salesiano</a>
        </div>

        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Buscar noticias...">
        </div>


        <div class="hamburger" onclick="toggleMenu()">
            <span></span><span></span><span></span>
        </div>

        <ul class="nav-links" id="navLinks">
            <li><a href="index.php">Inicio</a></li>
            <strong><li><a href="noticia.php">Noticias</a></li></strong>
           <li><a href="laudato.php">Laudato 'SI</a></li>
            <li><a href="about.php">Acerca de</a></li>
            <li id="panel_ctrl"><a href="panel_ctrl.php">Panel de control</a></li>
        </ul>
    </nav>


    <!-- contenido principal -->
    <div class="news-container">

        <div class="titulo-sub">
            <h1 class="titulo">Noticias Recientes</h1>
            <p class="subtitulo">Descubre las últimas novedades del PSAC</p>
        </div>

        <!-- por tema -->
        <div class="filtro-tema">
            <form action="" method="GET">
                <label for="tema">Filtrar por tema:</label>
                <select name="tema" id="tema" onchange="this.form.submit()">
                    <option value="">Todos</option>
                    <?php
                    $temas = $conexion->query("SELECT DISTINCT tema FROM publicacion");
                    while ($t = $temas->fetch_assoc()) {
                        $selected = (isset($_GET['tema']) && $_GET['tema'] == $t['tema']) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($t['tema']) . '" ' . $selected . '>' . htmlspecialchars($t['tema']) . '</option>';
                    }
                    ?>
                </select>
            </form>
        </div>

        <!-- CARDS DE NOTICIAS -->
        <div class="cards">
            <?php

            $temaFiltro = "";
            if (isset($_GET['tema']) && !empty($_GET['tema'])) {
                $tema = $conexion->real_escape_string($_GET['tema']);
                $temaFiltro = "WHERE tema = '$tema'";
            }

            $sql = $conexion->query("SELECT * FROM publicacion $temaFiltro ORDER BY fecha_publicacion DESC");

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
                echo "<p class='no-news'>No hay noticias disponibles por el momento.</p>";
            }

            $buscarFiltro = "";

            if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
                $busqueda = $conexion->real_escape_string($_GET['buscar']);
                $buscarFiltro = "WHERE titulo LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%'";
            }

            // Si hay filtro por tema, lo combinamos con el buscador
            if (!empty($temaFiltro)) {
                if (!empty($buscarFiltro)) {
                    $temaFiltro = str_replace("WHERE", "AND", $temaFiltro);
                    $buscarFiltro = $buscarFiltro . " " . $temaFiltro;
                }
            } else {
                $buscarFiltro = $buscarFiltro . " " . $temaFiltro;
            }

            // SQL final:
            $sql = $conexion->query("
    SELECT * FROM publicacion 
    $buscarFiltro
    ORDER BY fecha_publicacion DESC
");

            ?>
        </div>
    </div>

    <script src="scripts/index.js"></script>
    <script src="scripts/buscador.js"></script>

</body>



</html>