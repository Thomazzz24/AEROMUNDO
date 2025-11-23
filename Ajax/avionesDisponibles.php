<?php
ob_start();

ini_set('display_errors', '0');
error_reporting(0);

try {
    require_once(__DIR__ . "/../logica/Avion.php");
    require_once(__DIR__ . "/../logica/Vuelo.php");
    require_once(__DIR__ . "/../persistencia/Conexion.php");
    require_once(__DIR__ . "/../persistencia/VueloDAO.php");
} catch (Exception $e) {
    ob_end_clean();
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(500);
    die(json_encode(['error' => 'Error cargando dependencias: ' . $e->getMessage()]));
}

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['error' => 'Método no permitido']));
}

if(!isset($_POST["fecha_salida"]) || !isset($_POST["fecha_llegada"])) {
    http_response_code(400);
    die(json_encode(['error' => 'Parámetros faltantes']));
}

$fecha_salida = $_POST["fecha_salida"];
$fecha_llegada = $_POST["fecha_llegada"];

try {
    $vuelo = new Vuelo();
    $aviones = $vuelo->avionDisponible($fecha_salida, $fecha_llegada);

    if(!empty($aviones) && is_array($aviones)) {
        $data = [];
        foreach($aviones as $a) {
            $data[] = [
                'id' => $a->getId(),
                'modelo' => $a->getModelo(),
                'capacidad' => $a->getCapacidad()
            ];
        }
        die(json_encode(['data' => $data]));
    } else {
        die(json_encode(['error' => 'No hay aviones disponibles']));
    }
} catch (Exception $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Error interno del servidor']));
}
?>