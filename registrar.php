<?php
include("scripts/conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user = trim($_POST["user"]);
    $pass = $_POST["contrasena"];

    if ($user === "" || $pass === "") {
        $mensaje = "Por favor completa todos los campos.";
    } else {

        // 1. Verificar si el usuario ya existe
        $check = $conexion->prepare("SELECT id_usuario FROM usuario WHERE user_name = ?");
        $check->bind_param("s", $user);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $mensaje = "El usuario ya existe. Elige otro nombre.";
        } else {

            // 2. Hashear contraseña
            $hash = password_hash($pass, PASSWORD_DEFAULT);

            // 3. Guardar el usuario nuevo
            $insert = $conexion->prepare("INSERT INTO usuario (user_name, user_pass) VALUES (?, ?)");
            $insert->bind_param("ss", $user, $hash);

            if ($insert->execute()) {
                $mensaje = "Usuario creado exitosamente✔️";
                 header("Location: sesion.php");
            } else {
                $mensaje = "Error al registrar usuario.";
                 header("Location: registrar.php");
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="styles/login.css">
</head>

<body>

<header>
    <div class="logo-sls">
        <img src="src/logo-salesianos.png" alt="" width="50px">
    </div>
    <h1 id="titulo"><strong>EL DIARIO</strong> SALESIANO</h1>
</header>

<main>

    <div class="container">

        <form action="registrar.php" method="POST">
            <h2 id="sub-t">Crear Usuario</h2>

            <?php if ($mensaje): ?>
                <p style="color: yellow; text-align:center; font-weight:bold;">
                    <?= htmlspecialchars($mensaje); ?>
                </p>
            <?php endif; ?>

            <input type="text"
                   name="user"
                   placeholder="Nombre de usuario"
                   class="input"
                   required
                   autocomplete="off">

            <input type="password"
                   name="contrasena"
                   placeholder="Contraseña"
                   class="input"
                   required>

            <button type="submit" id="btn_enviar">Registrar</button>
            <p class="p_btn">¿Tienes una cuenta? <a href="sesion.php"> iniciar sesin</a></p>
        </form>

        <div class="logo">
            <img src="src/Saint John Don Bosco Colored.png" id="logo-donbosco">
        </div>

    </div>

</main>

    <footer>
        <p>© 2025 El Diario Salesiano — Todos los derechos reservados</p>
    </footer>

</body>

</html>
