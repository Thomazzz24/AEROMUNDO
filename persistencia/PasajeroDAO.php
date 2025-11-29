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
    
    public function activar($correo){
        return "UPDATE p1_usuario
                SET estado = '1'
                WHERE correo = '" . $correo . "'";
    }


    // REGISTRAR USUARIO
    public function registrarUsuario(){
        return "
            INSERT INTO p1_usuario (nombre, apellido, correo, clave, id_rol, estado)
            VALUES (
                '{$this->nombre}',
                '{$this->apellido}',
                '{$this->correo}',
                md5('{$this->clave}'),
                3,
                0
            )
        ";
    }

    // REGISTRAR PASAJERO
    public function registrarPasajero($idUsuario){
        return "
            INSERT INTO p1_pasajero (id_usuario)
            VALUES ({$idUsuario})
        ";
    }

    // AUTENTICAR → AHORA TRAE TAMBIÉN id_pasajero
    public function autenticar(){
        return "
            SELECT 
                u.id_usuario AS id,
                u.nombre,
                u.apellido,
                u.correo,
                u.id_rol AS rol,
                u.estado,
                u.fecha_registro AS fecharegistro,
                p.id_pasajero
            FROM p1_usuario u
            INNER JOIN p1_pasajero p ON p.id_usuario = u.id_usuario
            WHERE u.correo = '{$this->correo}'
              AND u.clave = md5('{$this->clave}')
              AND u.id_rol = 3
              AND u.estado = 1
        ";
    }

    public function consultar(){
        return "
            SELECT 
                u.id_usuario AS id,
                u.nombre,
                u.apellido,
                u.correo,
                u.id_rol AS rol,
                u.estado,
                u.fecha_registro AS fecharegistro,
                p.id_pasajero
            FROM p1_usuario u
            INNER JOIN p1_pasajero p ON p.id_usuario = u.id_usuario
        ";
    }

    public function consultarPorId(){
        return "
            SELECT 
                u.id_usuario AS id,
                u.nombre,
                u.apellido,
                u.correo,
                u.id_rol AS rol,
                u.estado,
                u.fecha_registro AS fecharegistro,
                p.id_pasajero
            FROM p1_usuario u
            INNER JOIN p1_pasajero p ON p.id_usuario = u.id_usuario
            WHERE u.id_usuario = {$this->id}
        ";
    }

    public function consultarTodos(){
        return "
            SELECT 
                u.id_usuario AS id,
                u.nombre,
                u.apellido,
                u.correo,
                u.id_rol AS rol,
                u.estado,
                u.fecha_registro AS fecharegistro,
                p.id_pasajero
            FROM p1_usuario u
            INNER JOIN p1_pasajero p ON p.id_usuario = u.id_usuario
            WHERE u.id_rol = 3
        ";
    }

    public function cambiarEstado($estado){
        return "
            UPDATE p1_usuario
            SET estado = {$this->estado}
            WHERE id_usuario = {$this->id}
        ";
    }
}
