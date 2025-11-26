<?php

class Conexion {
       private $conexion;
    private $resultado;
    private $charset="utf8";
    private $hosname = "localhost";

    //private $databadase = "aeropuerto";
    //private $username = "root";
    //private $password = "";

    private $databadase = "	itiud_aplint2";
    private $username = "itiud_aplint2";
    private $password = "GYesgQ118&";
    
    function abrir(){
        try{
            $option = [
                PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            $this->conexion = new PDO("mysql:host={$this->hosname};dbname={$this->databadase};charset={$this->charset}", 
                                    $this->username, 
                                    $this->password,
                                    $option);
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function cerrar() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }

    public function ejecutar($sentencia) {
        $this->resultado = $this->conexion->query($sentencia);
        if ($this->resultado === false) {
            echo "Error en la consulta: " . $this->conexion->error;
        }
    }

    public function extraer() {
        if ($this->resultado instanceof mysqli_result) {
            return $this->resultado->fetch_row();
        }
        return null;
    }

    public function registro() {
        if ($this->resultado instanceof mysqli_result) {
            return $this->resultado->fetch_assoc();
        }
        return null;
    }

    public function filas() {
        return $this->resultado instanceof mysqli_result ? $this->resultado->num_rows : 0;
    }

    public function ultimoId() {
        return $this->conexion ? $this->conexion->insert_id : null;
    }
}

?>
