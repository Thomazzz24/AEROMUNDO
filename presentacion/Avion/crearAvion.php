<?php
if (!isset($_SESSION["id"]) || $_SESSION["rol"] != "admin") {
    header("Location: ?pid=" . base64_encode("noAutorizado.php"));
}
include_once("logica/Admin.php");

$admin = new Admin($_SESSION["id"]);
$admin->consultarPorId();

include("administrador/sesionAdmin.php");  
include_once("logica/Avion.php");             

$avion = new Avion();
$listaAviones = $avion->consultarTodos();
?>
