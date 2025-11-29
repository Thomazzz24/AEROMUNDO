<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/PasajeroDAO.php");

class Pasajero extends Persona
{   
    public function __construct($id = 0, $nombre = "", $apellido = "", $correo = "", $clave = "", $rol = 0, $estado = "", $fecharegistro = "")
    {
        parent::__construct($id, $nombre, $apellido, $correo, $clave, $rol, $estado, $fecharegistro);
    }
    public function autenticar()
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $pasajeroDAO = new PasajeroDAO("", "", "", $this->correo, $this->clave, "", "", "");
        $conexion->ejecutar($pasajeroDAO->autenticar());
        $tupla = $conexion->registro();
        $conexion->cerrar();
        if ($tupla != null) {
            $this->id = $tupla["id_pasajero"];
            $this->nombre = $tupla["nombre"];
            $this->apellido = $tupla["apellido"];
            $this->rol = $tupla["rol"];
            $this->estado = $tupla["estado"];
            $this->fecharegistro = $tupla["fecharegistro"];
            return true;
        } else {
            return false;
        }
    }
    public function registrar()
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $pasajeroDAO = new PasajeroDAO("", $this->nombre, $this->apellido, $this->correo, $this->clave, "pasajero", $this->estado, "");
        $conexion->ejecutar($pasajeroDAO->registrarUsuario());
        $idUsuario = $conexion->ultimoId();
        $conexion->ejecutar($pasajeroDAO->registrarPasajero($idUsuario));
        $conexion->cerrar();
    }
  public function activar($correo)
{
    $conexion = new Conexion();
    $conexion->abrir();
    $pasajeroDAO = new PasajeroDAO("", "", "", $correo, "", "", "", ""); 
    $conexion->ejecutar($pasajeroDAO->activar($correo)); 
    $conexion->cerrar();
}

    public function consultar(){
        $conexion = new Conexion();
        $conexion->abrir();
        $pasajeroDAO = new PasajeroDAO($this->id, "", "", "", "", "", "", "");
        $conexion->ejecutar($pasajeroDAO->consultar());
        $pasajeros = array();
        while($tupla = $conexion->registro()){
            $pasajero = new Pasajero($tupla["id"], $tupla["nombre"], $tupla["apellido"], $tupla["correo"], "", $tupla["rol"], $tupla["estado"], $tupla["fecharegistro"]);
            array_push($pasajeros, $pasajero);
        }
        $conexion->cerrar();
        return $pasajeros;
    }
    public function consultarPorId()
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $pasajeroDAO = new PasajeroDAO($this->id, "", "", "", "", "", "", "");
        $conexion->ejecutar($pasajeroDAO->consultarPorId());
        $tupla = $conexion->registro();
        $conexion->cerrar();
        if ($tupla != null) {
            $this->id = $tupla["id"];
            $this->nombre = $tupla["nombre"];
            $this->apellido = $tupla["apellido"];
            $this->correo = $tupla["correo"];
            $this->rol = $tupla["rol"];
            $this->estado = $tupla["estado"];
            $this->fecharegistro = $tupla["fecharegistro"];
            return true;
        }
        return false;
    }
    public function consultarTodos()
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $pasajeroDAO = new PasajeroDAO("", "", "", "", "", "", "", "");
        $conexion->ejecutar($pasajeroDAO->consultarTodos());
        $resultados = [];
        while ($tupla = $conexion->registro()) {
            $pasajero = new Pasajero($tupla["id"], $tupla["nombre"], $tupla["apellido"], $tupla["correo"], "", $tupla["rol"], $tupla["estado"], $tupla["fecharegistro"]);
            array_push($resultados, $pasajero);
        }
        $conexion->cerrar();
        return $resultados;
    }
    public function cambiarEstado($estado)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $pasajeroDAO = new PasajeroDAO($this->id, "", "", "", "", "", $estado, "");
        $conexion->ejecutar($pasajeroDAO->cambiarEstado($estado));
        $conexion->cerrar();
    }
}
