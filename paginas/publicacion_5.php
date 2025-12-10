<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>✨Retiro de Adviento – Primer Ciclo de Secundaria✨</title>
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

<h1 class="header-title">✨Retiro de Adviento – Primer Ciclo de Secundaria✨</h1>

<div class="meta-publicacion">
    <p class="tema-publicacion"><strong>Tema:</strong> PASTORAL</p>
    <p class="fecha-publicacion">📅 08/12/2025 10:27 PM</p>
</div>

<div class='media-container'><img src='../uploads/1765247242_575752111_18327631192240825_1228632495749063908_n.webp'></div>

<div class="descripcion-publicacion">Tema: “Un corazón nuevo”<br />
<br />
Durante la primera semana de Adviento, vivimos una experiencia hermosa y transformadora junto a nuestros estudiantes de 1ro, 2do y 3ro de secundaria, donde este tiempo litúrgico nos invitó a detenernos, reflexionar y abrir el corazón a Dios. ✨<br />
<br />
Fue un espacio para mirar hacia dentro, reconocer lo que somos, soltar lo que pesa y permitir que Jesús venga a renovar nuestra vida con un corazón nuevo ❤️.  A través de la oración y la reflexión, nuestros estudiantes aprendieron que siempre es posible empezar de nuevo, cambiar, sanar y crecer.<br />
<br />
Que este Adviento siga preparando nuestros corazones para recibir al Niño Jesús con alegría, esperanza y amor. <br />
<br />
“Señor, crea en nosotros un corazón nuevo” (cf. Salmo 51).</div>

<div class="like-box">
    <button id="likeToggle" class="like-button" data-id="5" data-liked="">
        <img id="likeIcon" src="../src/like.png" alt="Like">
        <span id="likeCount">2</span>
    </button>
</div>


<div class="comentarios-box">
    <h3>💬 Comentarios <span>1</span></h3>
    
    <div class='comentario'>
        <strong>stancy:</strong>
        <p>Hola</p>
        <small>2025-12-09 10:42:11</small>
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