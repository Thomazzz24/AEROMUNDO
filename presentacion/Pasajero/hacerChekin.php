<?php
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

require_once("logica/tiquete.php");
require_once("logica/Vuelo.php");
require_once("logica/Checkin.php");

if (!isset($_GET["id_tiquete"]) || !is_numeric($_GET["id_tiquete"])) {
   echo "<div class='alert alert-danger text-center'>Tiquete inválido (ID no recibido).</div>";
   exit();
}

$id_tiquete = $_GET["id_tiquete"];

$tiquete = new Tiquete($id_tiquete);

if (!$tiquete->consultarPorId()) {
   echo "<div class='alert alert-danger text-center'>Tiquete inexistente o inválido.</div>";
   exit();
}

$sesion_id    = $_SESSION["id"];
$id_comprador = $tiquete->getId_comprador();
$id_pasajero  = $tiquete->getId_pasajero();

if ($sesion_id != $id_comprador && $sesion_id != $id_pasajero) {
   echo "<div class='alert alert-danger text-center'>
            No tienes permiso para hacer check-in para este tiquete.
         </div>";
   exit();
}

$vuelo = new Vuelo($tiquete->getId_vuelo());
$vuelo->consultarPorId();


$ahora  = time();
$salida = strtotime($vuelo->getFecha_salida());
$diff   = $salida - $ahora;

if ($diff > 24 * 3600) {
   echo "<div class='alert alert-warning text-center'>
            Aún no puedes hacer check-in. Debes esperar a que falten 24 horas.
         </div>";
   exit();
}

if ($diff <= 0) {
   echo "<div class='alert alert-danger text-center'>
            El vuelo ya salió.
         </div>";
   exit();
}

$check = new Checkin();
if ($check->consultarPorTiquete($id_tiquete)) {
   echo "<div class='alert alert-success text-center'>
            Ya realizaste el check-in antes.
         </div>";
   exit();
}

$checkin = new Checkin(null, $id_tiquete, date("Y-m-d H:i:s"));
$checkin->insertar();

$tiquete->hacerCheckin();

header("Location: presentacion/pasajero/generarPasabordo.php?id_tiquete=$id_tiquete");
exit();
