<?php
abstract class Persona{
    protected $id;
    protected $nombre;
    protected $apellido;
    protected $correo;
    protected $clave;
    protected $rol;
    protected $estado;
    protected $fecharegistro;
    public function __construct($id, $nombre, $apellido, $correo, $clave, $rol, $estado, $fecharegistro){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->rol = $rol;
        $this->estado = $estado;
        $this->fecharegistro = $fecharegistro;
    }
    public function getId(){
        return $this->id;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function getCorreo(){
        return $this->correo;
    }
    public function getClave(){
        return $this->clave;
    }
    public function getRol(){
        return $this->rol;
    }
    public function getEstado(){
        return $this->estado;
    }
    public function getFecharegistro(){
        return $this->fecharegistro;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setApellido($apellido){
        $this->apellido = $apellido;
    }
    public function setCorreo($correo){
        $this->correo = $correo;
    }
    public function setClave($clave){
        $this->clave = $clave;
    }
}