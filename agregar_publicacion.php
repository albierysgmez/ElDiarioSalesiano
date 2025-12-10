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
    <title>Agregar Publicación</title>
</head>
<body>

<style>

    * {
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
    text-decoration: none;
    color: white;
}

body {
    background: #1e1e1e;
    color: #edf0f2;
}

.navbar {
    width: 100%;
    padding: 15px 40px;
    background: #111;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
}

.nav-left {
    display: flex;
    align-items: center;
}

.logo {
    width: 35px;
    margin-right: 10px;
}

.nav-title {
    font-size: 20px;
    font-weight: bold;
}

.nav-links {
    display: flex;
    list-style: none;
}

.nav-links li {
    margin-left: 25px;
}

.nav-links a {
    text-decoration: none;
    color: white;
    font-size: 15px;
    opacity: 0.8;
    padding: 6px 10px;
    transition: 0.2s;
}

.nav-links a:hover {
    background: rgba(255, 255, 255, 0.25);
    opacity: 1;
}


/* Hamburguesa */
.hamburger {

    display: none;
    flex-direction: column;
    cursor: pointer;
    gap: 4px;
    
}



.hamburger span {
    width: 25px;
    height: 3px;
    background: #fff;
    border-radius: 3px;
}


/* ---------- NAVBAR RESPONSIVE ---------- */
@media (max-width: 820px) {
    .hamburger {
        display: flex;
    }

    .nav-links {
        position: absolute;
        top: 70px;
        right: -260px;
        width: 230px;
        background: #111;
        flex-direction: column;
        padding: 25px;
        gap: 12px;
        border-left: 1px solid rgba(255,255,255,0.1);
        transition: right 0.35s ease;
    }

    .nav-links.show {
        right: 0;
    }
}
    /* ---------- ESTILOS GENERALES ---------- */

body {
    background: #1e1e1e;
    color: #edf0f2;
    font-family: Arial, Helvetica, sans-serif;
    padding-top: 120px;
}

/* CENTRAR CONTENIDO PRINCIPAL */
.main-box {
    width: 90%;
    max-width: 700px;
    margin: auto;
    background: #111;
    padding: 40px;
    border-radius: 15px;
    border: 1px solid rgba(255,255,255,0.15);
    box-shadow: 0 0 15px rgba(0,0,0,0.4);
}

/* TITULO */
h2 {
    text-align: center;
    font-size: 28px;
    margin-bottom: 25px;
    font-weight: 700;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.4);
}

/* ---------- FORMULARIO ---------- */

form {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

label {
    font-size: 15px;
    opacity: 0.9;
    margin-bottom: -8px;
}

input[type="text"],
textarea,
select {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    background: #222;
    border: 1px solid rgba(255,255,255,0.15);
    color: #fff;
    font-size: 15px;
    outline: none;
    transition: 0.2s;
}

textarea {
    height: 120px;
    resize: vertical;
}

input[type="file"] {
    color: #fff;
    font-size: 14px;
}

input:focus,
textarea:focus,
select:focus {
    border-color: rgba(255,255,255,0.35);
}

/* BOTÓN */
button {
    background: #0066ff;
    color: #fff;
    border: none;
    padding: 14px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.2s;
}

button:hover {
    background: #0050d1;
}

/* RESPONSIVE */
@media (max-width: 600px) {
    .main-box {
        padding: 25px;
    }

    h2 {
        font-size: 22px;
    }
}

footer {
    text-align: center;
    padding: 15px 0;
    color: #ccc;
    background: #111;
    width: 100%;
    margin-top: auto;
    position: relative;
}



</style>

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
            <li><a href="../laudato.php">Laudato 'SI</a></li>
            <li><a href="about.php">Acerca de</a></li>
            <li id="panel_ctrl">
                <a href="panel_ctrl.php">Panel de control</a>
            </li>
        </ul>
    </nav>


<div class="main-box">

    <h2>Agregar Nueva Publicación</h2>

    <form action="scripts/insertar_publicacion.php" method="POST" enctype="multipart/form-data">

        <label>Título:</label>
        <input type="text" name="titulo" required>

        <label>Descripción:</label>
        <textarea name="descripcion" required></textarea>

        <label for="tema">Tema:</label>
        <select name="tema" id="tema" required>
            <option value="">Selecciona un tema</option>
            <option value="GENERAL">GENERAL</option>
            <option value="INFORMATICA">INFORMATICA</option>
            <option value="PROMOCION">PROMOCION</option>
            <option value="CONTABILIDAD">CONTABILIDAD</option>
            <option value="TURISMO">TURISMO</option>
            <option value="MERCADEO">MERCADEO</option>
            <option value="ACONDICIONAMIENTO FISICO">ACONDICIONAMIENTO FISICO</option>
            <option value="PASTORAL">PASTORAL</option>
            <option value="DEPORTE">DEPORTE</option>
            <option value="MUSICA">MUSICA</option>
            <option value="ARTE">MUSICA</option>
            <option value="LAUDATO">LAUDATO 'SI</option>
        </select>

        <label>Imagen:</label>
        <input type="file" name="imagen" accept="image/*" required>

        <label>Video (opcional):</label>
        <input type="file" name="video" accept="video/mp4,video/webm,video/ogg">

        <button type="submit">Guardar Publicación</button>
    </form>

</div>
    <footer>
        <p>© 2025 El Diario Salesiano — Todos los derechos reservados</p>
    </footer>

    <script src="/scripts/index.js"></script>
</body>
</html>
