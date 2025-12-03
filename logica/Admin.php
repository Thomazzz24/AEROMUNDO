<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/AdminDAO.php");
class Admin extends Persona
{
    public function __construct($id = 0, $nombre = "", $apellido = "", $correo = "", $clave = "", $rol = 0, $estado = 0, $fecharegistro = "")
    {
        parent::__construct($id, $nombre, $apellido, $correo, $clave, $rol, $estado, $fecharegistro);
    }
    public function autenticar()
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $adminDAO = new AdminDAO("", "", "", $this->correo, $this->clave, "", "", "");
        $conexion->ejecutar($adminDAO->autenticar());
        $tupla = $conexion->registro();
        $conexion->cerrar();
        if ($tupla != null) {
            $this->id = $tupla["id"];
            $this->nombre = $tupla["nombre"];
            $this->apellido = $tupla["apellido"];
            $this->correo = $tupla["correo"];
            $this->rol = 1;
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
        $adminDAO = new AdminDAO("", $this->nombre, $this->apellido, $this->correo, $this->clave, "admin", "activo", "");
        $conexion->ejecutar($adminDAO->registrar());
        $conexion->cerrar();
    }

    public function consultarPorId()
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $adminDAO = new AdminDAO($this->id, "", "", "", "", "", "", "");
        $conexion->ejecutar($adminDAO->consultarPorId());
        $tupla = $conexion->registro();
        $conexion->cerrar();
        if ($tupla != null) {
            $this->nombre = $tupla["nombre"];
            $this->apellido = $tupla["apellido"];
            $this->correo = $tupla["correo"];
            $this->estado = $tupla["estado"];
            return true;
        }
        return false;
    }
}
