<?php
require_once("persistencia/TiqueteDAO.php");
require_once("persistencia/Conexion.php");

class Tiquete {

    private $id_tiquete;
    private $id_comprador;
    private $id_vuelo;
    private $id_pasajero;
    private $nombre_pasajero;
    private $documento;
    private $asiento;
    private $precio;
    private $fecha_compra;

    public function __construct(
        $id_tiquete = 0,
        $id_comprador = 0,
        $id_vuelo = 0,
        $id_pasajero = null,
        $nombre_pasajero = "",
        $documento = "",
        $asiento = "",
        $precio = 0,
        $fecha_compra = ""
    ){
        $this->id_tiquete = $id_tiquete;
        $this->id_comprador = $id_comprador;
        $this->id_vuelo = $id_vuelo;
        $this->id_pasajero = $id_pasajero;
        $this->nombre_pasajero = $nombre_pasajero;
        $this->documento = $documento;
        $this->asiento = $asiento;
        $this->precio = $precio;
        $this->fecha_compra = $fecha_compra;
    }

    // Getters
    public function getId_tiquete() { return $this->id_tiquete; }
    public function getId_comprador() { return $this->id_comprador; }
    public function getId_vuelo() { return $this->id_vuelo; }
    public function getId_pasajero() { return $this->id_pasajero; }
    public function getNombre_pasajero() { return $this->nombre_pasajero; }
    public function getDocumento() { return $this->documento; }
    public function getAsiento() { return $this->asiento; }
    public function getPrecio() { return $this->precio; }
    public function getFecha_compra() { return $this->fecha_compra; }

    // Insertar tiquete
    public function insertar() {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new TiqueteDAO(
            0,
            $this->id_comprador,
            $this->id_vuelo,
            $this->id_pasajero,
            $this->nombre_pasajero,
            $this->documento,
            $this->asiento,
            $this->precio
        );
        $conexion->ejecutar($dao->insertar());
        $this->id_tiquete = $conexion->ultimoId();
        $conexion->cerrar();
        return $this->id_tiquete;
    }

    // Obtener asientos ocupados de un vuelo
    public function obtenerAsientosOcupados($id_vuelo) {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new TiqueteDAO();
        $conexion->ejecutar($dao->obtenerAsientosOcupados($id_vuelo));
        
        $asientos = [];
        while ($tupla = $conexion->registro()) {
            $asientos[] = $tupla['asiento'];
        }
        
        $conexion->cerrar();
        return $asientos;
    }

    // Validar si hay espacio disponible en el vuelo
    public function validarDisponibilidad($id_vuelo, $cantidad_pasajeros) {
        $conexion = new Conexion();
        $conexion->abrir();
        
        // Obtener capacidad del avión
        $query = "SELECT a.capacidad 
                FROM p1_avion a
                INNER JOIN p1_vuelo v ON v.id_avion = a.id_avion
                WHERE v.id_vuelo = $id_vuelo";
        
        $conexion->ejecutar($query);
        $resultado = $conexion->registro();
        $capacidad = $resultado ? (int)$resultado['capacidad'] : 0;
        
        // Contar tiquetes ya vendidos
        $dao = new TiqueteDAO();
        $conexion->ejecutar($dao->contarTiquetesVuelo($id_vuelo));
        $tupla = $conexion->registro();
        $vendidos = $tupla ? (int)$tupla['total'] : 0;
        
        $conexion->cerrar();
        
        $disponibles = $capacidad - $vendidos;
        
        return [
            'disponible' => ($disponibles >= $cantidad_pasajeros),
            'capacidad' => $capacidad,
            'vendidos' => $vendidos,
            'disponibles' => $disponibles
        ];
    }

    // Generar asiento automático disponible
    public function generarAsientoDisponible($id_vuelo) {
        $asientosOcupados = $this->obtenerAsientosOcupados($id_vuelo);
        
        // Generar asientos hasta encontrar uno libre
        $filas = 30; // Máximo de filas
        $columnas = ['A', 'B', 'C', 'D', 'E', 'F'];
        
        for ($fila = 1; $fila <= $filas; $fila++) {
            foreach ($columnas as $col) {
                $asiento = $fila . $col;
                if (!in_array($asiento, $asientosOcupados)) {
                    return $asiento;
                }
            }
        }
        
        return null; // No hay asientos disponibles
    }

    // Consultar tiquetes de un pasajero
    public function consultarPorPasajero($id_pasajero) {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new TiqueteDAO();
        $conexion->ejecutar($dao->consultarPorPasajero($id_pasajero));
        
        $tiquetes = [];
        while ($tupla = $conexion->registro()) {
            $tiquete = new Tiquete(
                $tupla['id_tiquete'],
                $tupla['id_comprador'],
                $tupla['id_vuelo'],
                $tupla['id_pasajero'],
                $tupla['nombre_pasajero'],
                $tupla['documento'],
                $tupla['asiento'],
                $tupla['precio'],
                $tupla['fecha_compra']
            );
            $tiquetes[] = $tiquete;
        }
        
        $conexion->cerrar();
        return $tiquetes;
    }

    // Consultar todos los tiquetes
    public function consultarTodos() {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new TiqueteDAO();
        $conexion->ejecutar($dao->consultarTodos());
        
        $tiquetes = [];
        while ($tupla = $conexion->registro()) {
            $tiquete = new Tiquete(
                $tupla['id_tiquete'],
                $tupla['id_comprador'],
                $tupla['id_vuelo'],
                $tupla['id_pasajero'],
                $tupla['nombre_pasajero'],
                $tupla['documento'],
                $tupla['asiento'],
                $tupla['precio'],
                $tupla['fecha_compra']
            );
            $tiquetes[] = $tiquete;
        }
        
        $conexion->cerrar();
        return $tiquetes;
    }
}