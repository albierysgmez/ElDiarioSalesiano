<?php
$conexion = new mysqli("localhost", "root", "", "bd_diario_salesianoplg");

if ($conexion->connect_errno) {
    die("Error al conectar a la base de datos.");
}

$conexion->set_charset("utf8");
?>

