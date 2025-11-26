<?php
class AdminDAO{
    private $id;
    private $nombre;
    private $apellido;
    private $correo;
    private $clave;
    private $rol;
    private $estado;
    private $fecharegistro;
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
    public function autenticar(){
        return "SELECT u.id_usuario AS id, u.nombre, u.apellido, u.correo,
                    u.estado, u.fecha_registro
                FROM p1_usuario u
                WHERE u.correo = '".$this->correo."'
                AND u.clave = md5('".$this->clave."')
                AND u.id_rol = 1
                AND u.estado = 1";
    }
    public function registrar(){
        return "INSERT INTO p1_usuario (nombre, apellido, correo, clave, id_rol, estado)
                VALUES ('".$this->nombre."', '".$this->apellido."', '".$this->correo."', 
                md5('".$this->clave."'), 1, 1)";
    }

    public function consultarPorId(){
        return "SELECT nombre, apellido, correo, estado
                FROM p1_usuario 
                WHERE id_usuario = ".$this->id;
    }
}