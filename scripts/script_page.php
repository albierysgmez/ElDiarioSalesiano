<?php
session_start();
include("conexion.php");

// Validar ID
if (!isset($_GET['id'])) {
    die("❌ No se envió ID de publicación.");
}

$id = intval($_GET['id']);

// Buscar publicación
$sql = "SELECT * FROM publicacion WHERE id_publicacion = $id LIMIT 1";
$res = $conexion->query($sql);

if (!$res || $res->num_rows === 0) {
    die("❌ No se encontró la publicación.");
}

$fila = $res->fetch_assoc();

// Datos base
$titulo = htmlspecialchars($fila['titulo']);
$descripcion = nl2br(htmlspecialchars($fila['descripcion']));
$tema = htmlspecialchars($fila['tema']);

$fecha_raw = $fila['fecha_publicacion'];
$fecha = $fecha_raw ? date("d/m/Y h:i A", strtotime($fecha_raw)) : "Fecha no disponible";

// Media
$imagen = $fila['imagen'];
$video  = $fila['video'];

// Root (subimos desde /scripts a raíz)
$root = realpath(__DIR__ . "/..");
$uploads_dir = $root . "/uploads";
$paginas_dir = $root . "/paginas";

// Asegurar carpeta
if (!is_dir($paginas_dir)) mkdir($paginas_dir, 0777, true);

// Procesar media
$media_html = "";
if ($imagen && file_exists("$uploads_dir/" . basename($imagen))) {
    $img = basename($imagen);
    $media_html .= "<div class='media-container'><img src='../uploads/$img'></div>";
}
if ($video && file_exists("$uploads_dir/" . basename($video))) {
    $vid = basename($video);
    $media_html .= "<div class='media-container'><video controls><source src='../uploads/$vid'></video></div>";
}

// -------------------------------
// ❤️ SISTEMA DE LIKES
// -------------------------------
$sqlLikes = $conexion->query("SELECT COUNT(*) AS total FROM likes WHERE id_publicacion=$id");
$totalLikes = $sqlLikes->fetch_assoc()['total'];

$dadoLike = false;
if (isset($_SESSION['id_usuario'])) {
    $uid = $_SESSION['id_usuario'];
    $resLike = $conexion->query("SELECT 1 FROM likes WHERE id_publicacion=$id AND id_usuario=$uid");
    $dadoLike = $resLike->num_rows > 0;
}

// -------------------------------
// COMENTARIOS
// -------------------------------
$comentariosSQL = $conexion->query("
    SELECT c.*, u.user_name 
    FROM comentarios c
    INNER JOIN usuario u ON u.id_usuario=c.id_usuario
    WHERE c.id_publicacion=$id
    ORDER BY c.fecha DESC
");

$comentarios_html = "";
while ($c = $comentariosSQL->fetch_assoc()) {
    $u = htmlspecialchars($c['user_name']);
    $t = nl2br(htmlspecialchars($c['comentario']));
    $f = $c['fecha'];

    $comentarios_html .= "
    <div class='comentario'>
        <strong>$u:</strong>
        <p>$t</p>
        <small>$f</small>
    </div>";
}

$sqlCantComentarios = $conexion->query("
    SELECT COUNT(*) AS total_coment
    FROM comentarios
    WHERE id_publicacion = $id
");

$totalComentarios = $sqlCantComentarios->fetch_assoc()["total_coment"];


// -------------------------------
// 📌 FORMULARIOS (sin PHP dentro del HTML)
// -------------------------------
$like_form_html = "";
$coment_form_html = "";

// SI NO HAY SESIÓN
if (!isset($_SESSION["id_usuario"])) {
    $like_form_html = "<p>Debes <a href='../sesion.php'>iniciar sesión</a> para dar like.</p>";
    $coment_form_html = "<p>Debes <a href='../sesion.php' id = 'link_sesion'>iniciar sesión</a> para comentar.</p>";
}

// SI HAY SESIÓN
else {
    $like_form_html = "
    <button id='likeToggle' class='like-button' 
        data-liked='" . ($dadoLike ? "1" : "0") . "' 
        data-id='{$id}'>
        <img id='likeIcon' src='../src/" . ($dadoLike ? "like2.png" : "like.png") . "'>
        <span id='likeCount'>{$totalLikes}</span>
    </button>";

    $coment_form_html = "
    <form method='POST' action='../scripts/comentar.php'>
        <input type='hidden' name='id_publicacion' value='{$id}'>
        <textarea name='comentario' placeholder='Escribe tu comentario...' required></textarea>
        <button>Publicar comentario</button>
    </form>";
}

// -------------------------------
// 📌 HTML FINAL SIN PHP
// -------------------------------
$contenido = <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>$titulo</title>
<link rel="stylesheet" href="../styles/script_page.css">
</head>

<body>

<nav class="navbar">
    <div class="nav-left">
        <img src="../src/logo-salesianos.png" alt="Logo" class="logo">
        <a href="index.php" class="nav-title">El Diario Salesiano</a>
    </div>

    <div class="hamburger" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <ul class="nav-links" id="navLinks">
    <li><a href="../index.php">Inicio</a></li>
    <li><a href="../noticia.php">Noticias</a></li>
    <li><a href="../laudato.php">Laudato 'SI</a></li>
    <li><a href="../about.php">Acerca de</a></li>
    <li id="panel_ctrl"><a href="panel_ctrl.php">Panel de control</a></li>
    </ul>
</nav>


<main class="container">

<h1 class="header-title">$titulo</h1>

<div class="meta-publicacion">
    <p class="tema-publicacion"><strong>Tema:</strong> $tema</p>
    <p class="fecha-publicacion">📅 $fecha</p>
</div>

$media_html

<div class="descripcion-publicacion">$descripcion</div>

<div class="like-box">
    <button id="likeToggle" class="like-button" data-id="$id" data-liked="$liked_attr">
        <img id="likeIcon" src="../src/like.png" alt="Like">
        <span id="likeCount">$totalLikes</span>
    </button>
</div>


<div class="comentarios-box">
    <h3>💬 Comentarios <span>$totalComentarios</span></h3>
    $comentarios_html
    $coment_form_html
</div>

</main>

<script>
    const userRol = window.userRol || "";
const ctrl = document.getElementById("panel_ctrl");

if (userRol === "admin") {
    ctrl.style.display = "block";
} else {
    ctrl.style.display = "none";
}



    console.log(userRol);

    /* --- MENU RESPONSIVE --- */
    function toggleMenu() {
        document.getElementById('navLinks').classList.toggle('show');
    }
    window.toggleMenu = toggleMenu;

    document.addEventListener('click', function(e) {
        const links = document.getElementById('navLinks');
        const hamburger = document.querySelector('.hamburger');
        if (!links.contains(e.target) && !hamburger.contains(e.target)) {
            links.classList.remove('show');
        }
    });
// LIKE TOGGLE JS
document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("likeToggle");
    if (!btn) return;

    const icon = document.getElementById("likeIcon");
    const count = document.getElementById("likeCount");

    btn.addEventListener("click", () => {
        const id = btn.dataset.id;
        const liked = btn.dataset.liked === "1";

        fetch("../scripts/like_toggle.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id_publicacion=" + id
        })
        .then(r => r.json())
        .then(data => {
            if (data.error === "not_logged") {
                alert("Debes iniciar sesión para dar like.");
                setTimeout(() => {
        window.location.href = "../sesion.php";
            }, 2000); // 2 segundos
                
                return;
            }

            count.textContent = data.total;

            icon.style.transform = "scale(0.4)";
            icon.style.opacity = "0";

            setTimeout(() => {
                icon.src = "../src/" + (data.status === "added" ? "like2.png" : "like.png");
                btn.dataset.liked = data.status === "added" ? "1" : "0";
                icon.style.transform = "scale(1)";
                icon.style.opacity = "1";
            }, 180);
        });
    });
});
</script>

</body>

    <footer>
        <p>© 2025 El Diario Salesiano — Todos los derechos reservados</p>
    </footer>
</html>
HTML;

// Guardar página generada
file_put_contents($paginas_dir . "/publicacion_$id.php", $contenido);

// Redirigir
header("Location: ../paginas/publicacion_$id.php");
exit;
