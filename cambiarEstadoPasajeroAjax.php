<?php
require_once ("logica/Persona.php");
require_once ("logica/Pasajero.php");

$idPasajero = $_GET["idPasajero"];
$estadoNuevo = $_GET["estado"];
$pasajero = new Pasajero($idPasajero);
$pasajero->cambiarEstado($estadoNuevo);
if ($estadoNuevo) {
    echo "<i class='fa-solid fa-check text-success fs-4'></i>";
} else {
    echo "<i class='fa-solid fa-x text-danger fs-4'></i>";
}