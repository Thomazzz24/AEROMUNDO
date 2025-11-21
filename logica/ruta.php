<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/rutaDAO.php");

class Ruta {
    private $id;
    private $origen;
    private $destino;
    private $duracion;

    public function __construct($id = 0, $origen = "", $destino = "", $duracion = 0) {
        $this->id = $id;
        $this->origen = $origen;
        $this->destino = $destino;
        $this->duracion = $duracion;
    }

    public function getId() { return $this->id; }
    public function getOrigen() { return $this->origen; }
    public function getDestino() { return $this->destino; }
    public function getDuracion() { return $this->duracion; }

    public function setOrigen($origen) { $this->origen = $origen; }
    public function setDestino($destino) { $this->destino = $destino; }
    public function setDuracion($duracion) { $this->duracion = $duracion; }

    // ============= CRUD ============= //

    public function registrar() {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new RutaDAO($this->id, $this->origen, $this->destino, $this->duracion);
        $conexion->ejecutar($dao->registrar());
        $conexion->cerrar();
    }

    public function consultarPorId() {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new RutaDAO($this->id, "", "", "");
        $conexion->ejecutar($dao->consultarPorId());
        $tupla = $conexion->registro();
        $conexion->cerrar();

        if ($tupla != null) {
            $this->origen = $tupla["origen"];
            $this->destino = $tupla["destino"];
            $this->duracion = $tupla["duracion_estimada"];
            return true;
        }
        return false;
    }

    public function consultarTodos() {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new RutaDAO("", "", "", "");
        $conexion->ejecutar($dao->consultarTodos());

        $resultados = [];
        while ($tupla = $conexion->registro()) {
            $ruta = new Ruta(
                $tupla["id_ruta"],
                $tupla["origen"],
                $tupla["destino"],
                $tupla["duracion_estimada"]
            );
            $resultados[] = $ruta;
        }
        $conexion->cerrar();
        return $resultados;
    }

    public function editar() {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new RutaDAO($this->id, $this->origen, $this->destino, $this->duracion);
        $conexion->ejecutar($dao->editar());
        $conexion->cerrar();
    }

    public function eliminar() {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new RutaDAO($this->id, "", "", "");
        $conexion->ejecutar($dao->eliminar());
        $conexion->cerrar();
    }
}