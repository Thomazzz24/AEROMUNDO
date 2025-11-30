<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(__DIR__ . "/../persistencia/Conexion.php");

try {
    $origen = isset($_GET["origen"]) ? trim($_GET["origen"]) : "";

    $conexion = new Conexion();
    $conexion->abrir();

    $where = "";
    if ($origen != "") {
        $where = "AND r.origen = '$origen'";
    }

    $query = "SELECT DISTINCT r.destino 
              FROM p1_ruta r
              INNER JOIN p1_vuelo v ON r.id_ruta = v.id_ruta
              WHERE v.fecha_salida >= NOW()
              $where
              ORDER BY r.destino ASC";

    $conexion->ejecutar($query);

    $destinos = [];
    while ($tupla = $conexion->registro()) {
        $destinos[] = $tupla["destino"];
    }

    $conexion->cerrar();

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($destinos, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        "error" => true,
        "mensaje" => $e->getMessage()
    ]);
}
?>