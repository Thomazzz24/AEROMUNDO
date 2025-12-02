<?php
require_once("persistencia/CheckinDAO.php");
require_once("persistencia/Conexion.php");

class Checkin {

    private $id_checkin;
    private $id_tiquete;
    private $fecha_checkin;

    public function __construct(
        $id_checkin = 0,
        $id_tiquete = 0,
        $fecha_checkin = ""
    ){
        $this->id_checkin = $id_checkin;
        $this->id_tiquete = $id_tiquete;
        $this->fecha_checkin = $fecha_checkin;
    }

    public function insertar() {
        $conexion = new Conexion();
        $conexion->abrir();

        $dao = new CheckinDAO(
            $this->id_checkin,
            $this->id_tiquete,
            $this->fecha_checkin
        );

        $conexion->ejecutar($dao->insertar());
        $this->id_checkin = $conexion->ultimoId();

        $conexion->cerrar();
        return $this->id_checkin;
    }

    public function consultarPorTiquete($id_tiquete) {
        $conexion = new Conexion();
        $conexion->abrir();

        $dao = new CheckinDAO();
        $conexion->ejecutar($dao->consultarPorTiquete($id_tiquete));

        $registro = $conexion->registro();

        $conexion->cerrar();

        return $registro ?: false;
    }
}
