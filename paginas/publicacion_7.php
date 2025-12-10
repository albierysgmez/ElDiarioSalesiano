<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>El Grupo ecológico ECOPSAC ha sido reconocido como Grupo Estrella 2025 ????</title>
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

<h1 class="header-title">El Grupo ecológico ECOPSAC ha sido reconocido como Grupo Estrella 2025 ????</h1>

<div class="meta-publicacion">
    <p class="tema-publicacion"><strong>Tema:</strong> LAUDATO</p>
    <p class="fecha-publicacion">📅 09/12/2025 08:56 PM</p>
</div>

<div class='media-container'><img src='../uploads/1765328212_587098253_18326088259240825_937573073675759315_n.webp'></div>

<div class="descripcion-publicacion">El Grupo ecológico ECOPSAC ha sido reconocido como Grupo Estrella 2025 ???? por la Unidad de Medioambiente de la Pastoral Juvenil Salesiana.<br />
Este premio no es solo una placa… es el reflejo de nuestro compromiso, del trabajo en equipo y del amor con el que cuidamos la Casa Común ???????? siguiendo los principios de la Laudato Si’ y el espíritu del Movimiento Ecológico Salesiano.<br />
<br />
???????? Cada acción, cada jornada ecológica, cada siembra, cada campaña… ¡ha dado fruto!<br />
Este reconocimiento nos recuerda que sí vale la pena sembrar esperanza, que juntos podemos hacer la diferencia y que nuestra misión apenas comienza ????????.<br />
<br />
Gracias a todos los jóvenes, colaboradores y personas que creen en este proyecto.<br />
Este premio también es de ustedes ????????.<br />
<br />
???? ECOPSAC: transformando, educando y cuidando la creación.<br />
¡Vamos por más! ????✨</div>

<div class="like-box">
    <button id="likeToggle" class="like-button" data-id="7" data-liked="">
        <img id="likeIcon" src="../src/like.png" alt="Like">
        <span id="likeCount">1</span>
    </button>
</div>


<div class="comentarios-box">
    <h3>💬 Comentarios <span>0</span></h3>
    
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