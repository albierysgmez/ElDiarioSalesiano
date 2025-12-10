<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>jjd</title>
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
    <li><a href="../deporte.php">Deporte</a></li>
    <li><a href="../about.php">Acerca de</a></li>
    <li id="panel_ctrl"><a href="panel_ctrl.php">Panel de control</a></li>
    </ul>
</nav>


<main class="container">

<h1 class="header-title">jjd</h1>

<div class="meta-publicacion">
    <p class="tema-publicacion"><strong>Tema:</strong> PASTORAL</p>
    <p class="fecha-publicacion">📅 06/12/2025 10:35 PM</p>
</div>

<div class='media-container'><img src='../uploads/1765074905_maquetar-sitio-web.png'></div>

<div class="descripcion-publicacion">djjdjdj</div>

<div class="like-box">
    <button id="likeToggle" class="like-button" data-id="1" data-liked="">
        <img id="likeIcon" src="../src/like.png" alt="Like">
        <span id="likeCount">2</span>
    </button>
</div>


<div class="comentarios-box">
    <h3>💬 Comentarios <span>7</span></h3>
    
    <div class='comentario'>
        <strong>lector:</strong>
        <p>cd</p>
        <small>2025-12-07 09:10:30</small>
    </div>
    <div class='comentario'>
        <strong>lector:</strong>
        <p>cxcxcxcxc</p>
        <small>2025-12-07 08:51:27</small>
    </div>
    <div class='comentario'>
        <strong>lector:</strong>
        <p>mxxmx</p>
        <small>2025-12-06 23:23:07</small>
    </div>
    <div class='comentario'>
        <strong>lector:</strong>
        <p>ndndnnd</p>
        <small>2025-12-06 23:23:03</small>
    </div>
    <div class='comentario'>
        <strong>admin:</strong>
        <p>kdkdk</p>
        <small>2025-12-06 22:41:18</small>
    </div>
    <div class='comentario'>
        <strong>admin:</strong>
        <p>mm</p>
        <small>2025-12-06 22:41:12</small>
    </div>
    <div class='comentario'>
        <strong>admin:</strong>
        <p>cx</p>
        <small>2025-12-06 22:37:21</small>
    </div>
    
    <form method='POST' action='../scripts/comentar.php'>
        <input type='hidden' name='id_publicacion' value='1'>
        <textarea name='comentario' placeholder='Escribe tu comentario...' required></textarea>
        <button>Publicar comentario</button>
    </form>
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