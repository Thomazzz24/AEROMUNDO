<?php
require_once(__DIR__ . "/../persistencia/Conexion.php");
require_once(__DIR__ . "/../persistencia/rutaDAO.php");

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
                
                // Convertir TIME a minutos
                $duracion_time = $tupla["duracion_estimada"];
                list($horas, $minutos, $segundos) = explode(':', $duracion_time);
                $this->duracion = ($horas * 60) + $minutos;
                
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
                // Convertir TIME a minutos
                $duracion_time = $tupla["duracion_estimada"];
                list($horas, $minutos, $segundos) = explode(':', $duracion_time);
                $duracion_minutos = ($horas * 60) + $minutos;
                
                $ruta = new Ruta(
                    $tupla["id_ruta"],
                    $tupla["origen"],
                    $tupla["destino"],
                    $duracion_minutos
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

        public function obtenerRutas(){
            $conexion = new conexion();
            $conexion->abrir();
            $dao = new RutaDAO("", "", "", "");
            $conexion->ejecutar($dao->obtenerRutas());
            $lista = [];
            while ($fila = $conexion->registro()){
                $lista[] = $fila;
            }
            $conexion->cerrar();
            return $lista;
        }

        public function rutasMasUsadas() {
            $conexion = new Conexion();
            $conexion->abrir();
            $dao = new rutaDAO("", "", "", "");
            $conexion->ejecutar($dao->rutasMasUsadas());
            
            $resultados = [];
            while ($tupla = $conexion->registro()) {
                $resultados[] = [$tupla["ruta"], (int)$tupla["cantidad"]];
            }
            
            $conexion->cerrar();
            return $resultados;
        }
    }