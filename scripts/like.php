<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id_usuario"])) {
    die("No logueado");
}

$idp = intval($_POST["id_publicacion"]);
$uid = intval($_SESSION["id_usuario"]);

$conexion->query("INSERT IGNORE INTO likes (id_publicacion, id_usuario) VALUES ($idp, $uid)");

header("Location: ../paginas/publicacion_$idp.php");
