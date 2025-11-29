<?php
require_once(__DIR__ . "/../persistencia/VueloDAO.php");
require_once(__DIR__ . "/../persistencia/Conexion.php");

class Vuelo {

    private $id_vuelo;
    private $id_ruta;
    private $id_avion;
    private $id_piloto_principal;
    private $id_copiloto;
    private $fecha_salida;
    private $fecha_llegada;
    private $estado;
    private $precio;

    private $origen;
    private $destino;
    private $modelo;
    private $piloto_principal;
    private $copiloto;

    public function __construct($id_vuelo = 0, $id_ruta = 0, $id_avion = 0, $id_piloto_principal = 0, $id_copiloto = 0, $fecha_salida = "", $fecha_llegada = "", $estado = 1, $precio = 0.00) {
        $this->id_vuelo = $id_vuelo;
        $this->id_ruta = $id_ruta;
        $this->id_avion = $id_avion;
        $this->id_piloto_principal = $id_piloto_principal;
        $this->id_copiloto = $id_copiloto;
        $this->fecha_salida = $fecha_salida;
        $this->fecha_llegada = $fecha_llegada;
        $this->estado = $estado;
        $this->precio = $precio;
    }

    // GETTERS
    function getId_vuelo(){ return $this->id_vuelo; }
    function getId_ruta(){ return $this->id_ruta; }
    function getId_avion(){ return $this->id_avion; }
    function getId_piloto_principal(){ return $this->id_piloto_principal; }
    function getId_copiloto(){ return $this->id_copiloto; }
    function getFecha_salida(){ return $this->fecha_salida; }
    function getFecha_llegada(){ return $this->fecha_llegada; }
    function getEstado(){ return $this->estado; }
    function getOrigen(){ return $this->origen; }
    function getDestino(){ return $this->destino; }
    function getModelo(){ return $this->modelo; }
    function getPiloto_principal(){ return $this->piloto_principal; }
    function getCopiloto(){ return $this->copiloto; }
    function getPrecio(){ return $this->precio; }

    // SETTERS
    function setId_ruta($id_ruta){ $this->id_ruta = $id_ruta; }
    function setId_avion($id_avion){ $this->id_avion = $id_avion; }
    function setId_piloto_principal($id_piloto_principal){ $this->id_piloto_principal = $id_piloto_principal; }
    function setId_copiloto($id_copiloto){ $this->id_copiloto = $id_copiloto; }
    function setFecha_salida($fecha_salida){ $this->fecha_salida = $fecha_salida; }
    function setFecha_llegada($fecha_llegada){ $this->fecha_llegada = $fecha_llegada; }
    function setEstado($estado){ $this->estado = $estado; }
    function setOrigen($origen){ $this->origen = $origen; }
    function setDestino($destino){ $this->destino = $destino; }
    function setModelo($modelo){ $this->modelo = $modelo; }
    function setPiloto_principal($piloto_principal){ $this->piloto_principal = $piloto_principal; }
    function setCopiloto($copiloto){ $this->copiloto = $copiloto; }
    function setPrecio($precio){ $this->precio = $precio; }

    // ============= CRUD ============= //
    public function registrar() {
        $conexion = new Conexion();
        $conexion->abrir();
        $vuelodao = new VueloDAO("", $this->id_ruta, $this->id_avion, $this->id_piloto_principal, $this->id_copiloto, $this->fecha_salida, $this->fecha_llegada, $this->estado, $this->precio);
        $conexion->ejecutar($vuelodao->registrar());
        $conexion->cerrar();
    }

    public function consultarPorId() {
        $conexion = new Conexion();
        $conexion->abrir();
        $vuelodao = new VueloDAO($this->id_vuelo, "", "", "", "", "", "", "");
        $conexion->ejecutar($vuelodao->consultarPorId());
        $tupla = $conexion->registro();
        $conexion->cerrar();

        if ($tupla != null) {
            $this->id_ruta = $tupla["id_ruta"];
            $this->id_avion = $tupla["id_avion"];
            $this->id_piloto_principal = $tupla["id_piloto_principal"];
            $this->id_copiloto = $tupla["id_copiloto"];
            $this->fecha_salida = $tupla["fecha_salida"];
            $this->fecha_llegada = $tupla["fecha_llegada"];
            $this->estado = $tupla["estado"];
            $this->precio = isset($tupla["precio"]) ? $tupla["precio"] : 0;
            $this->origen = $tupla["origen"];
            $this->destino = $tupla["destino"];
            $this->modelo = $tupla["modelo"];
            $this->piloto_principal = $tupla["piloto_principal"];
            $this->copiloto = $tupla["copiloto"];
            return true;
        }
        return false;
    }

    public function consultarTodos() {
        $conexion = new Conexion();
        $conexion->abrir();
        $vuelodao = new VueloDAO("", "", "", "", "", "", "", "");
        $conexion->ejecutar($vuelodao->consultarTodos());

        $resultados = [];
        while ($tupla = $conexion->registro()) {
            $vuelo = new Vuelo($tupla["id_vuelo"]);
            $vuelo->id_ruta = $tupla["id_ruta"];
            $vuelo->id_avion = $tupla["id_avion"];
            $vuelo->id_piloto_principal = $tupla["id_piloto_principal"];
            $vuelo->id_copiloto = $tupla["id_copiloto"];
            $vuelo->fecha_salida = $tupla["fecha_salida"];
            $vuelo->fecha_llegada = $tupla["fecha_llegada"];
            $vuelo->estado = $tupla["estado"];
            $vuelo->precio = isset($tupla["precio"]) ? $tupla["precio"] : 0;
            $vuelo->origen = $tupla["origen"];
            $vuelo->destino = $tupla["destino"];
            $vuelo->modelo = $tupla["modelo"];
            $vuelo->piloto_principal = $tupla["piloto_principal"];
            $vuelo->copiloto = $tupla["copiloto"];
            array_push($resultados, $vuelo);
        }

        $conexion->cerrar();
        return $resultados;
    }
    public function editar() {
        $conexion = new Conexion();
        $conexion->abrir();
        $vuelodao = new VueloDAO($this->id_vuelo, $this->id_ruta, $this->id_avion, $this->id_piloto_principal, $this->id_copiloto, $this->fecha_salida, $this->fecha_llegada, $this->estado, $this->precio);
        $conexion->ejecutar($vuelodao->editar());
        $conexion->cerrar();
    }
    public function eliminar() {
        $conexion = new Conexion();
        $conexion->abrir();
        $vuelodao = new VueloDAO($this->id_vuelo, "", "", "", "", "", "", "");
        $conexion->ejecutar($vuelodao->eliminar());
        $conexion->cerrar();
    }

    public function avionDisponible($fecha_salida, $fecha_llegada) {
                $conexion = new Conexion();
                $conexion->abrir();
                $dao = new vueloDAO();
                $conexion->ejecutar($dao->avionDisponible($fecha_salida, $fecha_llegada));
                $resultados = [];
                while ($tupla = $conexion->registro()) {
                    $avion = new Avion($tupla["id_avion"]);
                    $avion->setModelo($tupla["modelo"]);
                    $avion->setCapacidad($tupla["capacidad"]);
                    array_push($resultados, $avion);
                }
                $conexion->cerrar();
                return $resultados;
    }
    
    public function pilotoDisponible($fecha_salida, $fecha_llegada) {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new vueloDAO();
        $conexion->ejecutar($dao->pilotoDisponible($fecha_salida, $fecha_llegada));
        $resultados = [];
        while ($tupla = $conexion->registro()) {
            $piloto = new Piloto($tupla["id_piloto"]);
            $piloto->setNombre($tupla["nombre"]);
            $piloto->setApellido($tupla["apellido"]);
            array_push($resultados, $piloto);
        }
        $conexion->cerrar();
        return $resultados;
    }
    public function consultarProximosVuelos(){
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new vueloDAO();
        $conexion->ejecutar($dao->consultarProximosVuelos());
        $resultados = [];
        while ($tupla = $conexion->registro()) {
            $vuelo = new Vuelo($tupla["id_vuelo"]);
            $vuelo->id_ruta = $tupla["id_ruta"];
            $vuelo->id_avion = $tupla["id_avion"];
            $vuelo->id_piloto_principal = $tupla["id_piloto_principal"];
            $vuelo->id_copiloto = $tupla["id_copiloto"];
            $vuelo->fecha_salida = $tupla["fecha_salida"];
            $vuelo->fecha_llegada = $tupla["fecha_llegada"];
            $vuelo->estado = $tupla["estado"];
            $vuelo->precio = isset($tupla["precio"]) ? $tupla["precio"] : 0;
            $vuelo->origen = $tupla["origen"];
            $vuelo->destino = $tupla["destino"];
            $vuelo->modelo = $tupla["modelo"];
            $vuelo->piloto_principal = $tupla["piloto_principal"];
            $vuelo->copiloto = $tupla["copiloto"];
            array_push($resultados, $vuelo);
        }

        $conexion->cerrar();
        return $resultados;
    }
}
