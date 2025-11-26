<?php
class PilotoDAO{
    private $id;
    private $nombre;
    private $apellido;
    private $correo;
    private $clave;
    private $rol;
    private $estado;
    private $fecharegistro;
    private $foto_perfil;
    public function __construct($id, $nombre, $apellido, $correo, $clave, $rol, $estado, $fecharegistro, $foto_perfil = null){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->rol = $rol;
        $this->estado = $estado;
        $this->fecharegistro = $fecharegistro;
        $this->foto_perfil = $foto_perfil;
    }
    public function autenticar(){
    return "SELECT u.id_usuario AS id, u.nombre, u.apellido, u.correo, 
                    u.id_rol AS rol, u.estado, u.fecha_registro AS fecharegistro, 
                    p.foto_perfil
            FROM p1_usuario u 
            JOIN piloto p ON p.id_usuario = u.id_usuario 
            WHERE u.correo = '" . $this->correo . "' 
                AND u.clave = md5('" . $this->clave . "') 
                AND u.id_rol = 2 
                AND u.estado = 1";
}

    public function registrarUsuario(){
        return "INSERT INTO p1_usuario (nombre, apellido, correo, clave, id_rol, estado)
        VALUES ('" . $this->nombre . "', '" . $this->apellido . "', '" . $this->correo . "', md5('" . $this->clave . "'), 2, 1)";
    }

    public function registrarPiloto($idUsuario){
        $foto = $this->foto_perfil !== null ? "'" . $this->foto_perfil . "'" : "NULL";
        return "INSERT INTO p1_piloto (id_usuario, foto_perfil) VALUES (" . $idUsuario . ", " . $foto . ")";
    }

    public function consultarPorId(){
    return "SELECT u.id_usuario AS id, u.nombre, u.apellido, u.correo, 
                    u.id_rol AS rol, u.estado, u.fecha_registro AS fecharegistro, 
                    pi.id_piloto, pi.foto_perfil
            FROM p1_usuario u 
            JOIN piloto pi ON pi.id_usuario = u.id_usuario 
            WHERE u.id_usuario = " . $this->id;
    }
    public function consultarTodos() {
    return "SELECT 
                u.id_usuario AS id,
                u.nombre,
                u.apellido,
                u.correo,
                u.id_rol AS rol,
                u.estado,
                u.fecha_registro AS fecharegistro,
                p.foto_perfil
            FROM p1_usuario u
            JOIN piloto p ON p.id_usuario = u.id_usuario
            WHERE u.id_rol = 2";
    }
    public function cambiarEstado($estado){
        return "UPDATE p1_usuario SET estado = $estado WHERE id_usuario = " . $this->id;
    }
    public function editarPiloto() {
    return "UPDATE p1_usuario u
            JOIN piloto p ON p.id_usuario = u.id_usuario
            SET u.nombre = '" . $this->nombre . "',
                u.apellido = '" . $this->apellido . "',
                u.correo = '" . $this->correo . "'" .
                (!empty($this->foto_perfil) ? ", p.foto_perfil = '" . $this->foto_perfil . "'" : "") . "
            WHERE u.id_usuario = " . $this->id;
    }

    public function eliminarPiloto(){
        return "DELETE FROM p1_piloto WHERE id_usuario = " . $this->id;
    }
    public function eliminarUsuario(){
        return "DELETE FROM p1_usuario WHERE id_usuario = " . $this->id;
    }  

    
}