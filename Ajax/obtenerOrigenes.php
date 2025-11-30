<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(__DIR__ . "/../persistencia/Conexion.php");

try {
    $conexion = new Conexion();
    $conexion->abrir();

    $query = "SELECT DISTINCT r.origen 
              FROM p1_ruta r
              INNER JOIN p1_vuelo v ON r.id_ruta = v.id_ruta
              WHERE v.fecha_salida >= NOW()
              ORDER BY r.origen ASC";

    $conexion->ejecutar($query);

    $origenes = [];
    while ($tupla = $conexion->registro()) {
        $origenes[] = $tupla["origen"];
    }

    $conexion->cerrar();

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($origenes, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        "error" => true,
        "mensaje" => $e->getMessage()
    ]);
}
?>