<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("logica/Tiquete.php");
require_once("logica/Vuelo.php");
require_once("logica/Checkin.php");

/* ============================
   1. VALIDAR ID DEL TIQUETE
   ============================ */
if (!isset($_GET["id_tiquete"]) || !is_numeric($_GET["id_tiquete"])) {
    echo "<div class='alert alert-danger text-center'>Tiquete inválido (ID no recibido).</div>";
    exit();
}

$id_tiquete = $_GET["id_tiquete"];

/* ============================
   2. CONSULTAR TIQUETE
   ============================ */
$tiquete = new Tiquete($id_tiquete);

if (!$tiquete->consultarPorId()) {
    echo "<div class='alert alert-danger text-center'>Tiquete inexistente o inválido.</div>";
    exit();
}

/* ============================
   3. VALIDAR PERMISOS
   ============================ */
$sesion_id    = $_SESSION["id"];
$id_comprador = $tiquete->getId_comprador();
$id_pasajero  = $tiquete->getId_pasajero();

if ($sesion_id != $id_comprador && $sesion_id != $id_pasajero) {
    echo "<div class='alert alert-danger text-center'>
            No tienes permiso para hacer check-in para este tiquete.
          </div>";
    exit();
}

/* ============================
   4. CONSULTAR VUELO
   ============================ */
$vuelo = new Vuelo($tiquete->getId_vuelo());
$vuelo->consultarPorId();

/* ============================
   5. VALIDAR HORARIO DE CHECK-IN
   ============================ */
$ahora  = time();
$salida = strtotime($vuelo->getFecha_salida());
$diff   = $salida - $ahora;

// Falta más de 24h
if ($diff > 24 * 3600) {
    echo "<div class='alert alert-warning text-center'>
            Aún no puedes hacer check-in. Debes esperar a que falten 24 horas.
          </div>";
    exit();
}

// Ya salió
if ($diff <= 0) {
    echo "<div class='alert alert-danger text-center'>
            El vuelo ya salió.
          </div>";
    exit();
}

/* ============================
   6. VALIDAR SI YA HIZO CHECK-IN
   ============================ */
$check = new Checkin();
if ($check->consultarPorTiquete($id_tiquete)) {
    echo "<div class='alert alert-success text-center'>
            Ya realizaste el check-in antes.
          </div>";
    exit();
}

/* ============================
   7. REGISTRAR CHECK-IN
   ============================ */
$checkin = new Checkin(null, $id_tiquete, date("Y-m-d H:i:s"));
$checkin->insertar();

/* ============================
   8. ACTUALIZAR ESTADO DEL TIQUETE
   ============================ */
$tiquete->hacerCheckin();

/* ============================
   9. REDIRIGIR A GENERAR PDF
   ============================ */
header("Location: presentacion/pasajero/generarPasabordo.php?id_tiquete=$id_tiquete");
exit();
