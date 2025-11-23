<?php
ini_set('display_errors', '0');
error_reporting(0);
ob_start();

require_once(__DIR__ . "/../logica/ruta.php");

$idRuta = isset($_GET["idRuta"]) ? intval($_GET["idRuta"]) : 0;
$salida = isset($_GET["salida"]) ? $_GET["salida"] : "";

header('Content-Type: application/json; charset=utf-8');

if($idRuta <= 0 || $salida == "") {
    http_response_code(400);
    echo json_encode(["error" => "Parámetros inválidos."]);
    exit();
}

$salida = str_replace("T", " ", $salida);
if (strlen($salida) === 16) { 
    $salida .= ":00";
}

$salidaTimestamp = strtotime($salida);
if($salidaTimestamp === false) {
    http_response_code(400);
    echo json_encode(["error" => "Formato de fecha y hora de salida inválido."]);
    exit();
}

$ruta = new Ruta($idRuta);
if(!$ruta->consultarPorId()) {
    http_response_code(404);
    echo json_encode(["error" => "Ruta no encontrada."]);
    exit();
}

$minutos = intval($ruta->getDuracion());
$llegadaTimestamp = $salidaTimestamp + ($minutos * 60);
$llegada = date("Y-m-d H:i:s", $llegadaTimestamp);

ob_get_clean();
echo json_encode(["fecha_llegada" => $llegada]);
?>