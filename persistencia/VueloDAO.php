<?php
class VueloDAO {

    private $id_vuelo;
    private $id_ruta;
    private $id_avion;
    private $id_piloto_principal;
    private $id_copiloto;
    private $fecha_salida;
    private $fecha_llegada;
    private $estado;

    function __construct($id_vuelo = "", $id_ruta = "", $id_avion = "", $id_piloto_principal = "", $id_copiloto = "", $fecha_salida = "", $fecha_llegada = "", $estado = "") {
        $this->id_vuelo = $id_vuelo;
        $this->id_ruta = $id_ruta;
        $this->id_avion = $id_avion;
        $this->id_piloto_principal = $id_piloto_principal;
        $this->id_copiloto = $id_copiloto;
        $this->fecha_salida = $fecha_salida;
        $this->fecha_llegada = $fecha_llegada;
        $this->estado = $estado;
    }

    function consultarTodos() {
        return "SELECT 
                    v.id_vuelo,
                    r.origen,
                    r.destino,
                    a.modelo,
                    v.fecha_salida,
                    v.fecha_llegada,
                    v.estado
                FROM vuelo v
                INNER JOIN ruta r ON v.id_ruta = r.id_ruta
                INNER JOIN avion a ON v.id_avion = a.id_avion
                ORDER BY v.fecha_salida ASC";
    }
}
