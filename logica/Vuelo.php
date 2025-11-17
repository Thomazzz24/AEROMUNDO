<?php
require_once("persistencia/VueloDAO.php");
require_once("persistencia/Conexion.php");

class Vuelo {

    private $id_vuelo;
    private $id_ruta;
    private $id_avion;
    private $id_piloto_principal;
    private $id_copiloto;
    private $fecha_salida;
    private $fecha_llegada;
    private $estado;
    private $conexion;
    private $vueloDAO;

    function __construct($id_vuelo = "") {
        $this->id_vuelo = $id_vuelo;
        $this->conexion = new Conexion();
        $this->vueloDAO = new VueloDAO();
    }

    function consultarTodos() {
        $this->conexion->abrir();
        $this->conexion->ejecutar($this->vueloDAO->consultarTodos());
        
        $vuelos = array();
        while (($resultado = $this->conexion->extraer()) != null) {
            $vuelos[] = $resultado;
        }

        $this->conexion->cerrar();
        return $vuelos;
    }
}
