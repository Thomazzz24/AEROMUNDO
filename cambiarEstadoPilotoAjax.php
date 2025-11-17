<?php
require_once("logica/Persona.php");
require_once("logica/Piloto.php");
$idPiloto = $_GET["idPiloto"];
$estado = $_GET["estado"];
$piloto = new Piloto($idPiloto);
$piloto->cambiarEstado($estado);    
if ($estado == 1) {
    echo "<i class='fa-solid fa-check text-success fs-4'></i>";
} else {
    echo "<i class='fa-solid fa-x text-danger fs-4'></i>";
}