<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== "admin") {
    header("Location: index.php");
    exit();
}
?>

<?php include("scripts/conexion.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicaciones</title>

    <!-- RUTA CORREGIDA AL CSS -->
    <link rel="stylesheet" href="/styles/panel_ctrl.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-left">
        <!-- RUTA CORREGIDA AL LOGO -->
        <img src="src/logo-salesianos.png" alt="Logo" class="logo">

        <!-- RUTA CORREGIDA A INDEX -->
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
        <li><a href="laudato.php">Laudato 'si</a></li>
        <li><a href="about.php">Acerca de</a></li>

        <li id="panel_ctrl"><a href="panel_ctrl.php">Panel de control</a></li>
    </ul>
</nav>

<aside>
    <!-- RUTA CORREGIDA A agregar_publicacion.php -->
    <a href="agregar_publicacion.php" style="color:white;">
        <button>
            <h1 style="text-align:center;">Publicaciones</h1>
            <div style="text-align:center; margin-bottom:20px;">
                ➕ Agregar Nueva Publicación
            </div>
        </button>
    </a>
</aside>

<!-- FILTRO POR TEMA -->
<div class="filtro-tema" style="text-align:center; margin:20px 0;">
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

<main class="cont_principal">

<?php
$temaFiltro = "";
if (isset($_GET['tema']) && !empty($_GET['tema'])) {
    $tema = $conexion->real_escape_string($_GET['tema']);
    $temaFiltro = "WHERE tema = '$tema'";
}

$sql = $conexion->query("SELECT * FROM publicacion $temaFiltro ORDER BY fecha_publicacion DESC");

if ($sql && $sql->num_rows > 0) {

    while ($fila = $sql->fetch_assoc()) {

        // Determinar contenido multimedia
        $media = "";
        if (!empty($fila['imagen'])) {
            $media = "<img src='" . $fila['imagen'] . "' alt='' class='img_publicacion'>";
        } else if (!empty($fila['video'])) {
            $media = "<video class='img_publicacion' width='100%' controls>
                        <source src='" . $fila['video'] . "' type='video/mp4'>
                        Tu navegador no soporta videos.
                      </video>";
        } else {
            $media = "<div class='img_publicacion' style='width:100%;height:180px;background:#ccc;text-align:center;line-height:180px;color:#555;'>Sin multimedia</div>";
        }

        echo '
        <div class="card">
            '.$media.'
            <h3>'.$fila['titulo'].'</h3>
            <p><strong>Tema:</strong> '.$fila['tema'].'</p>
            <p>'.$fila['descripcion'].'</p>

            <div class="opciones">
                <a href="editar_publicacion.php?id='.$fila['id_publicacion'].'">✏ Editar</a>

                <!-- RUTA CORREGIDA AL SCRIPT DE ELIMINAR -->
                <a href="scripts/eliminar_publicacion.php?id='.$fila['id_publicacion'].'"
                   onclick="return confirm(\'¿Seguro que deseas eliminar?\')">🗑 Eliminar</a>
            </div>
        </div>';
    }

} else {
    echo "<p style='text-align:center;'>No hay publicaciones disponibles.</p>";
}
?>

</main>

    <footer>
        <p>© 2025 El Diario Salesiano — Todos los derechos reservados</p>
    </footer>

</body>
</html>
