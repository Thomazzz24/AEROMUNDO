<?php

class Conexion {
    private $conexion;
    private $resultado;

    public function abrir() {
        if ($_SERVER['REMOTE_ADDR'] == "::1") {
            $this->conexion = new mysqli("localhost", "root", "", "aerolinea", 3306);
        }else {
            $this->conexion = new mysqli(
                "localhost", 
                "itiud_cocinaetilica", 
                "UXpieQ728%", 
                "itiud_cocinaetilica"
            );
        }
        if ($this->conexion->connect_errno) {
            die("Error de conexión: " . $this->conexion->connect_error);
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

    public function registro() {
        // Devuelve la primera fila como array asociativo si la consulta devolvió un result set
        if ($this->resultado instanceof mysqli_result) {
            return $this->resultado->fetch_assoc();
        }
        return null;
    }

    public function filas() {
        return $this->resultado instanceof mysqli_result ? $this->resultado->num_rows : 0;
    }

    public function ultimoId(){
        return $this->conexion ? $this->conexion->insert_id : null;
    }
}

?>
