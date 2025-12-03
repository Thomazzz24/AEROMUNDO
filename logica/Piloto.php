<?php
require_once(__DIR__ . "/../persistencia/Conexion.php");
require_once(__DIR__ . "/../persistencia/PilotoDAO.php");
class Piloto extends Persona{
    private $foto_perfil;
    public function __construct($id=0, $nombre="", $apellido="", $correo="", $clave="", $rol=0, $estado=0, $fecharegistro="", $foto_perfil=""){
        parent::__construct($id, $nombre, $apellido, $correo, $clave, $rol, $estado, $fecharegistro);
        $this->foto_perfil = $foto_perfil;
    }
    public function getFotoPerfil(){
        return $this->foto_perfil;
    }
    public function setFotoPerfil($foto_perfil){
        $this->foto_perfil = $foto_perfil;
    }
    public function autenticar(){
        $conexion = new Conexion();
        $conexion->abrir();
        $pilotoDAO = new PilotoDAO("", "", "", $this->correo, $this->clave, "", "", "");
        $conexion->ejecutar($pilotoDAO->autenticar());
        $tupla = $conexion->registro();
        $conexion->cerrar();
        if($tupla != null){
            $this->id = $tupla["id"];
            $this->nombre = $tupla["nombre"];
            $this->apellido = $tupla["apellido"];
            $this->rol = $tupla["rol"];
            $this->estado = $tupla["estado"];
            $this->fecharegistro = $tupla["fecharegistro"];
            $this->foto_perfil = $tupla["foto_perfil"];
            return true;
        } else {
            return false;
        }
    }
    public function registrar(){
        $conexion = new Conexion();
        $conexion->abrir();
        $pilotoDAO = new PilotoDAO("", $this->nombre, $this->apellido, $this->correo, $this->clave, "piloto", "activo", "", $this->foto_perfil);
        $conexion->ejecutar($pilotoDAO->registrarUsuario());
        $idUsuario = $conexion->ultimoId();
        $conexion->ejecutar($pilotoDAO->registrarPiloto($idUsuario));
        $conexion->cerrar();
    }

    public function consultarPorId(){
        $conexion = new Conexion();
        $conexion->abrir();
        $pilotoDAO = new PilotoDAO($this->id, "", "", "", "", "", "", "", "");
        $conexion->ejecutar($pilotoDAO->consultarPorId());
        $tupla = $conexion->registro();
        $conexion->cerrar();
        if($tupla != null){
            $this->id = $tupla["id"];
            $this->nombre = $tupla["nombre"];
            $this->apellido = $tupla["apellido"];
            $this->correo = $tupla["correo"];
            $this->rol = $tupla["rol"];
            $this->estado = $tupla["estado"];
            $this->fecharegistro = $tupla["fecharegistro"];
            $this->foto_perfil = isset($tupla["foto_perfil"]) ? $tupla["foto_perfil"] : null;
            return true;
        }
        return false;
    }

    public function consultarTodos(){
    $conexion = new Conexion();
    $conexion->abrir();
    $pilotoDAO = new PilotoDAO("", "", "", "", "", "", "", "", "");
    $conexion->ejecutar($pilotoDAO->consultarTodos());
    $resultados = [];
    while($tupla = $conexion->registro()){
        $piloto = new Piloto(
            $tupla["id"],           
            $tupla["nombre"],     
            $tupla["apellido"], 
            $tupla["correo"],      
            "",                    
            $tupla["rol"],      
            $tupla["estado"],     
            $tupla["fecharegistro"], 
            $tupla["foto_perfil"]  
        );
        $resultados[] = $piloto;
    }
    $conexion->cerrar();
    return $resultados;
    }
    public function cambiarEstado($estado){
        $conexion = new Conexion();
        $conexion->abrir();
        $pilotoDAO = new PilotoDAO($this->id , "", "", "", "", "", "", "", "");
        $conexion->ejecutar($pilotoDAO ->cambiarEstado($estado));
        $conexion->cerrar();
    }
    public function editar(){
        $conexion = new Conexion();
        $conexion->abrir();
        $pilotoDAO = new PilotoDAO($this->id, $this->nombre, $this->apellido, $this->correo, "", "", "", "", $this->foto_perfil);
        $conexion->ejecutar($pilotoDAO->editarPiloto());
        $conexion->cerrar();
    }
    public function eliminar(){
        $conexion = new Conexion();
        $conexion->abrir();
        $pilotoDAO = new PilotoDAO($this->id , "", "", "", "", "", "", "", "");
        $conexion->ejecutar($pilotoDAO ->eliminarPiloto());
        $conexion->ejecutar($pilotoDAO ->eliminarUsuario());
        $conexion->cerrar();
    }

    public function pilotosMasVuelos() {
        $conexion = new Conexion();
        $conexion->abrir();
        $dao = new PilotoDAO("", "", "", "", "", "", "", "");
        $conexion->ejecutar($dao->pilotosMasVuelos());
        
        $resultados = [];
        while ($tupla = $conexion->registro()) {
            $resultados[] = [$tupla["piloto"], (int)$tupla["cantidad"]];
        }
        
        $conexion->cerrar();
        return $resultados;
    }
    // Agregar este método en la clase Piloto
public function obtenerIdPiloto() {
    $conexion = new Conexion();
    $conexion->abrir();
    $pilotoDAO = new PilotoDAO($this->id, "", "", "", "", "", "", "", "");
    $conexion->ejecutar($pilotoDAO->obtenerIdPiloto());
    $tupla = $conexion->registro();
    $conexion->cerrar();
    
    if($tupla != null) {
        return $tupla["id_piloto"];
    }
    return null;
}

}