<?php
require_once(__DIR__ . "/../persistencia/Conexion.php");
require_once(__DIR__ . "/../persistencia/AvionDAO.php");

class Avion {
    private $id;
    private $modelo;
    private $capacidad;
    private $estado;

    public function __construct($id = 0, $modelo = "", $capacidad = 0, $estado = 1) {
        $this->id = $id;
        $this->modelo = $modelo;
        $this->capacidad = $capacidad;
        $this->estado = $estado;
    }

    public function getId() { return $this->id; }
    public function getModelo() { return $this->modelo; }
    public function getCapacidad() { return $this->capacidad; }
    public function getEstado() { return $this->estado; }

    public function setModelo($modelo) { $this->modelo = $modelo; }
    public function setCapacidad($capacidad) { $this->capacidad = $capacidad; }
    public function setEstado($estado) { $this->estado = $estado; }

    // ============= CRUD ============= //

    public function registrar() {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new AvionDAO("", $this->modelo, $this->capacidad, $this->estado);
        $conexion->ejecutar($dao->registrar());
        $conexion->cerrar();
    }

    public function consultarPorId() {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new AvionDAO($this->id, "", "", "");
        $conexion->ejecutar($dao->consultarPorId());
        $tupla = $conexion->registro();
        $conexion->cerrar();

        if ($tupla != null) {
            $this->modelo = $tupla["modelo"];
            $this->capacidad = $tupla["capacidad"];
            $this->estado = $tupla["estado"];
            return true;
        }
        return false;
    }

    public function consultarTodos() {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new AvionDAO("", "", "", "");
        $conexion->ejecutar($dao->consultarTodos());

        $resultados = [];
        while ($tupla = $conexion->registro()) {
            $avion = new Avion(
                $tupla["id_avion"],
                $tupla["modelo"],
                $tupla["capacidad"],
                $tupla["estado"]
            );
            $resultados[] = $avion;
        }
        $conexion->cerrar();
        return $resultados;
    }

    public function editar() {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new AvionDAO($this->id, $this->modelo, $this->capacidad, $this->estado);
        $conexion->ejecutar($dao->editar());
        $conexion->cerrar();
    }

    public function cambiarEstado($estado) {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new AvionDAO($this->id, "", "", $estado);
        $conexion->ejecutar($dao->cambiarEstado());
        $conexion->cerrar();
    }

    public function eliminar() {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new AvionDAO($this->id, "", "", "");
        $conexion->ejecutar($dao->eliminar());
        $conexion->cerrar();
    }

    public function avionesMasUsados() {
    $conexion = new Conexion();
    $conexion->abrir();
    $dao = new AvionDAO("", "", "", "");
    $conexion->ejecutar($dao->avionesMasUsados());
    
    $resultados = [];
    while ($tupla = $conexion->registro()) {
        $resultados[] = [$tupla["avion"], (int)$tupla["cantidad"]];
    }
    
    $conexion->cerrar();
    return $resultados;
}

    
}
