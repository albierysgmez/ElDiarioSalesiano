<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión en EL DIARIO SALESIANO</title>
    <link rel="stylesheet" href="styles/login.css">
    <link rel="shortcut icon" href="src/logo-salesianos.png" type="image/x-icon">
</head>

<body>

    <header>

        <div class="logo-sls">
            <img src="src/logo-salesianos.png" alt="" width="50px">
        </div>

        <h1 id="titulo"><Strong>EL DIARIO</Strong> SALESIANO</h1>

    </header>

<main>

    <div class="container">

        

<form action="/scripts/iniciar-sesion.php" method="POST">
    <h2 id="sub-t">Iniciar Sesion</h2>

    <input type="text" 
           name="user" 
           id="inp-user" 
           placeholder="Ingrese el usuario" 
           class="input"
           required
           autocomplete="off">

    <input type="password" 
           name="contrasena" 
           id="inp_contra" 
           placeholder="Contraseña" 
           class="input"
           required>


                <button type="submit" id="btn_enviar">Iniciar sesión</button>
    <p class="p_btn">¿No tienes cuenta? <a href="registrar.php">Crea una cuenta</a></p>
        


</form>


        <div class="logo">
            <img src="src/Saint John Don Bosco Colored.png" alt="Don Bosco" id="logo-donbosco">
        </div>

    </div>

</main>

    <footer>
        <p>© 2025 El Diario Salesiano — Todos los derechos reservados</p>
    </footer>
</body>

</html>