<?php

class Conexion {
    private $conexion;
    private $resultado;

    public function abrir() {

        // Si estás en local (XAMPP)
        if ($_SERVER['REMOTE_ADDR'] == "::1") {
            $this->conexion = new mysqli("localhost", "root", "", "aerolinea", 3306);
        } 
        // Si estás en el servidor ITIUD
        else {
            $this->conexion = new mysqli(
                "p1.itiud.org",     // 🔥 HOST DEL SERVIDOR ITIUD
                "itiud_aplint2",    // USUARIO BD
                "9IGmG24ue&",       // CLAVE BD
                "itiud_aplint"      // BASE DE DATOS
            );
        }

        // Validar conexión
        if ($this->conexion->connect_errno) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }

        // Charset
        $this->conexion->set_charset("utf8");
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
