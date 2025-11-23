<?php
ob_start();

ini_set('display_errors', '0');
error_reporting(0);

try {
    require_once(__DIR__ . "/../logica/Persona.php");
    require_once(__DIR__ . "/../logica/Piloto.php");
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
$exclude = isset($_POST["exclude_id"]) ? intval($_POST["exclude_id"]) : 0;

try {
    $vuelo = new Vuelo();
    $pilotos = $vuelo->pilotoDisponible($fecha_salida, $fecha_llegada);

    if(!empty($pilotos) && is_array($pilotos)) {
        $data = [];
        foreach ($pilotos as $p) {
            if($exclude !== 0 && $p->getId() == $exclude) continue;
            
            $data[] = [
                'id' => $p->getId(),
                'nombre' => $p->getNombre(),
                'apellido' => $p->getApellido()
            ];
        }
        
        if(empty($data)) {
            die(json_encode(['error' => 'No hay pilotos disponibles']));
        }
        
        die(json_encode(['data' => $data]));
    } else {
        die(json_encode(['error' => 'No hay pilotos disponibles']));
    }
} catch (Exception $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Error interno del servidor']));
}
?>