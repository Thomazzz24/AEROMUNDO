<?php
class TiqueteDAO {

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

    public function insertar() {
        // Manejar NULL para id_pasajero
        $idPasajeroSQL = ($this->id_pasajero === null || $this->id_pasajero === 0 || $this->id_pasajero === "")
            ? "NULL"
            : "'{$this->id_pasajero}'";

        return "INSERT INTO p1_tiquete (
                    id_comprador,
                    id_vuelo,
                    id_pasajero,
                    nombre_pasajero,
                    documento,
                    asiento,
                    precio,
                    fecha_compra
                ) VALUES (
                    '{$this->id_comprador}',
                    '{$this->id_vuelo}',
                    $idPasajeroSQL,
                    '{$this->nombre_pasajero}',
                    '{$this->documento}',
                    '{$this->asiento}',
                    '{$this->precio}',
                    NOW()
                )";
    }

    public function consultarPorId() {
        return "SELECT * FROM p1_tiquete
                WHERE id_tiquete = {$this->id_tiquete}";
    }

    public function consultarTodos() {
        return "SELECT t.*, 
                       v.fecha_salida, 
                       r.origen, 
                       r.destino
                FROM p1_tiquete t
                INNER JOIN p1_vuelo v ON t.id_vuelo = v.id_vuelo
                INNER JOIN p1_ruta r ON v.id_ruta = r.id_ruta
                ORDER BY t.fecha_compra DESC";
    }

    public function consultarPorPasajero($id_pasajero) {
        return "SELECT t.*, 
                       v.fecha_salida, 
                       v.fecha_llegada,
                       r.origen, 
                       r.destino,
                       a.modelo
                FROM p1_tiquete t
                INNER JOIN p1_vuelo v ON t.id_vuelo = v.id_vuelo
                INNER JOIN p1_ruta r ON v.id_ruta = r.id_ruta
                INNER JOIN p1_avion a ON v.id_avion = a.id_avion
                WHERE t.id_comprador = $id_pasajero
                ORDER BY t.fecha_compra DESC";
    }

    public function obtenerAsientosOcupados($id_vuelo) {
        return "SELECT asiento 
                FROM p1_tiquete 
                WHERE id_vuelo = $id_vuelo";
    }

    public function contarTiquetesVuelo($id_vuelo) {
        return "SELECT COUNT(*) as total 
                FROM p1_tiquete 
                WHERE id_vuelo = $id_vuelo";
    }

    public function validarDocumentoDuplicado($id_vuelo, $documento) {
        return "SELECT COUNT(*) as existe
                FROM p1_tiquete
                WHERE id_vuelo = $id_vuelo
                AND documento = '$documento'";
    }
}