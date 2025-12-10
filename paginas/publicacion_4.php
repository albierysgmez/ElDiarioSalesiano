<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>✨???? Celebración de la Solemnidad de la Inmaculada Concepción de María</title>
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

<h1 class="header-title">✨???? Celebración de la Solemnidad de la Inmaculada Concepción de María</h1>

<div class="meta-publicacion">
    <p class="tema-publicacion"><strong>Tema:</strong> PASTORAL</p>
    <p class="fecha-publicacion">📅 08/12/2025 08:13 PM</p>
</div>

<div class='media-container'><img src='../uploads/1765239192_590416110_18327691699240825_3382528851385144611_n.webp'></div>

<div class="descripcion-publicacion">Con un corazón lleno de fe, alegría y gratitud, nuestra comunidad educativa se reunió para celebrar la Solemnidad de la Inmaculada Concepción de la Santísima Virgen María, Madre pura, humilde y obediente al plan de Dios. Fue un día especial donde elevamos nuestras oraciones y nuestro canto a quien fue preservada del pecado desde su concepción para ser digna morada del Salvador.<br />
<br />
Durante la Santa Eucaristía, pusimos bajo el amparo de María a nuestros estudiantes, docentes, directivos, familias y a toda la comunidad, pidiendo que nos cubra con su manto, nos cuide, nos acompañe y nos guíe por caminos de fe, esperanza y amor. Cada momento vivido nos recordó que María es ejemplo de entrega total, de confianza absoluta en Dios y de servicio silencioso.<br />
<br />
Inspirados también por el carisma de Don Bosco, renovamos nuestro compromiso de educar con el corazón, formando buenos cristianos y honrados ciudadanos, confiando siempre en la protección maternal de María, especialmente bajo la advocación de María Inmaculada.<br />
<br />
Que esta celebración mariana siga fortaleciendo nuestro caminar como familia educativa y que la Inmaculada Concepción continúe siendo luz, refugio y esperanza para todos nosotros.<br />
???????? ¡María Inmaculada, ruega por nosotros! ????????</div>

<div class="like-box">
    <button id="likeToggle" class="like-button" data-id="4" data-liked="">
        <img id="likeIcon" src="../src/like.png" alt="Like">
        <span id="likeCount">2</span>
    </button>
</div>


<div class="comentarios-box">
    <h3>💬 Comentarios <span>1</span></h3>
    
    <div class='comentario'>
        <strong>admin:</strong>
        <p>Hola Fany</p>
        <small>2025-12-08 22:11:03</small>
    </div>
    <p>Debes <a href='../sesion.php' id = 'link_sesion'>iniciar sesión</a> para comentar.</p>
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