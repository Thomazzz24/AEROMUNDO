<?php
require_once("persistencia/TiqueteDAO.php");
require_once("persistencia/Conexion.php");

class Tiquete {

    private $id;
    private $idComprador;
    private $idVuelo;
    private $idPasajero;
    private $nombrePasajero;
    private $documento;
    private $asiento;
    private $precio;

    private $conexion;
    private $tiqueteDAO;

    public function __construct(
        $id = 0,
        $idComprador = 0,
        $idVuelo = 0,
        $idPasajero = 0,
        $nombrePasajero = "",
        $documento = "",
        $asiento = "",
        $precio = 0
    ){
        $this->id = $id;
        $this->idComprador = $idComprador;
        $this->idVuelo = $idVuelo;
        $this->idPasajero = $idPasajero;
        $this->nombrePasajero = $nombrePasajero;
        $this->documento = $documento;
        $this->asiento = $asiento;
        $this->precio = $precio;

        $this->conexion = new Conexion();
        $this->tiqueteDAO = new TiqueteDAO(
            $id,
            $idComprador,
            $idVuelo,
            $idPasajero,
            $nombrePasajero,
            $documento,
            $asiento,
            $precio
        );
    }

    public function insertar(){
        $this->conexion->abrir();
        $this->conexion->ejecutar($this->tiqueteDAO->insertar());
        $this->id = $this->conexion->ultimoId();
        $this->conexion->cerrar();
        return $this->id;
    }
}
