<?php
session_start();
require_once "conexion.php";

/* -----------------------------------------------------------
   1. BLOQUEAR ACCESO SI NO SE ENVÍA POR POST
----------------------------------------------------------- */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /sesion.php");
    exit();
}

/* -----------------------------------------------------------
   2. CONFIGURACIONES DE SEGURIDAD DE LA SESIÓN
----------------------------------------------------------- */
session_regenerate_id(true); // Previene session fixation

ini_set("session.cookie_httponly", 1); // JS no puede leer cookies
ini_set("session.cookie_secure", isset($_SERVER['HTTPS']));
ini_set("session.cookie_samesite", "Strict");

/* -----------------------------------------------------------
   3. LIMPIEZA Y VALIDACIÓN DE DATOS
----------------------------------------------------------- */
$user = isset($_POST['user']) ? trim($_POST['user']) : "";
$pass = $_POST['contrasena'] ?? "";

// Básico
if ($user === "" || $pass === "") {
    echo "<script>
            alert('Por favor completa usuario y contraseña.');
            window.location = '/sesion.php';
          </script>";
    exit();
}

// Anti-XSS
$user = htmlspecialchars($user, ENT_QUOTES, 'UTF-8');

/* -----------------------------------------------------------
   4. VERIFICAR SI LA CONEXIÓN EXISTE
----------------------------------------------------------- */
if (!isset($conexion)) {
    die("ERROR: La conexión no está definida.");
}


/* -----------------------------------------------------------
   6. CONSULTA SEGURA (Prepared Statement)
----------------------------------------------------------- */
$sql = "SELECT id_usuario, user_name, user_pass, rol FROM usuario WHERE user_name = ? LIMIT 1";
$stmt = $conexion->prepare($sql);

if (!$stmt) {
    error_log("Error prepare(): " . $conexion->error);
    die("Error interno.");
}

$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

/* -----------------------------------------------------------
   7. REVISAR SI EXISTE EL USUARIO
----------------------------------------------------------- */
if ($result->num_rows !== 1) {
    $_SESSION["login_attempts"]++;
    echo "<script>
            alert('Usuario no existe.');
            window.location = '/registrar.php';
          </script>";
    exit();
}

$row = $result->fetch_assoc();
$hashBD = $row['user_pass'];

/* -----------------------------------------------------------
   8. VERIFICAR CONTRASEÑA
----------------------------------------------------------- */
if (!password_verify($pass, $hashBD)) {
    $_SESSION["login_attempts"]++;
    echo "<script>
            alert('Contraseña incorrecta.');
            window.location = '/sesion.php';
          </script>";
    exit();
}

// Resetear intentos al iniciar sesión correctamente
$_SESSION["login_attempts"] = 0;

/* -----------------------------------------------------------
   9. CREAR SESIÓN SEGURA DEL USUARIO
----------------------------------------------------------- */
$_SESSION['id_usuario'] = $row['id_usuario'];
$_SESSION['user_name']  = $row['user_name'];
$_SESSION['rol']        = $row['rol'];

/* Protección adicional: identificación del navegador */
$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

/* -----------------------------------------------------------
   10. REHASH AUTOMÁTICO SI EL HASH ES ANTIGUO
----------------------------------------------------------- */
if (password_needs_rehash($hashBD, PASSWORD_DEFAULT)) {
    $newHash = password_hash($pass, PASSWORD_DEFAULT);

    $update = $conexion->prepare("UPDATE usuario SET user_pass = ? WHERE id_usuario = ?");
    if ($update) {
        $update->bind_param("si", $newHash, $row['id_usuario']);
        $update->execute();
    }
}

/* -----------------------------------------------------------
   11. REDIRIGIR A LA PÁGINA PRINCIPAL
----------------------------------------------------------- */
header("Location: /index.php");
exit();
