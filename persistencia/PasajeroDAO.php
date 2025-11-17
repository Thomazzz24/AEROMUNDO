<?php
class PasajeroDAO{
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
    public function registrarUsuario(){
        return "INSERT INTO usuario (nombre, apellido, correo, clave, id_rol, estado)
        VALUES ('" . $this->nombre . "', '" . $this->apellido . "', '" . $this->correo . "', md5('" . $this->clave . "'), 2, 1)";
    }
    public function registrarPasajero($idUsuario){
        return "INSERT INTO pasajero (id_usuario)
        VALUES (" . $idUsuario . ")"; 
    }
    public function autenticar(){
    return "SELECT u.id_usuario AS id, u.nombre, u.apellido, u.correo, u.id_rol AS rol, 
                    u.estado, u.fecha_registro AS fecharegistro
            FROM usuario u
            WHERE u.correo = '" . $this->correo . "' 
                AND u.clave = md5('" . $this->clave . "') 
                AND u.id_rol = 3       
                AND u.estado = 1";
}

    public function consultarPorId(){
        return "SELECT u.id_usuario AS id, u.nombre, u.apellido, u.correo, u.id_rol AS rol, u.estado, u.fecha_registro AS fecharegistro, p.id_pasajero \n" .
               "FROM usuario u JOIN pasajero p ON p.id_usuario = u.id_usuario \n" .
               "WHERE u.id_usuario = " . $this->id;
    }
    public function consultarTodos(){
        return "SELECT u.id_usuario AS id, u.nombre, u.apellido, u.correo, u.id_rol AS rol, u.estado, u.fecha_registro AS fecharegistro, p.id_pasajero \n" .
               "FROM usuario u JOIN pasajero p ON p.id_usuario = u.id_usuario";
    }
}