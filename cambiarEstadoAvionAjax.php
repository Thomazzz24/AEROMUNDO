<?php
require_once("logica/Avion.php");

$idAvion = $_GET["idAvion"];
$estado = $_GET["estado"];
$avion = new Avion($idAvion);
$avion->cambiarEstado($estado);    
if ($estado == 1) {
    echo "<button class='btn btn-success btn-sm'>Activo</button>";
} else {
    echo "<button class='btn btn-warning btn-sm'>Mantenimiento</button>";
}
