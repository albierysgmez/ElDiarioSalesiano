<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id_usuario"])) {
    die("No logueado");
}

$idp = intval($_POST["id_publicacion"]);
$uid = intval($_SESSION["id_usuario"]);
$comentario = $conexion->real_escape_string($_POST["comentario"]);

$conexion->query("INSERT INTO comentarios (id_publicacion, id_usuario, comentario)
VALUES ($idp, $uid, '$comentario')");

header("Location: ../paginas/publicacion_$idp.php");
