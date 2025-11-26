<?php

class Conexion {
    private $conexion;
    private $resultado;

    private $host = "localhost";
    private $database = "itiud_aplint";   // SIN espacios ocultos
    private $username = "itiud_aplint2";
    private $password = "9IGmG24ue&";

    public function abrir() {
        $this->conexion = @new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if ($this->conexion->connect_errno) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }

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

    public function registro() {
        if ($this->resultado instanceof mysqli_result) {
            return $this->resultado->fetch_assoc();
        }
        return null;
    }

    public function extraer() {
        if ($this->resultado instanceof mysqli_result) {
            return $this->resultado->fetch_row();
        }
        return null;
    }

    public function filas() {
        return ($this->resultado instanceof mysqli_result)
            ? $this->resultado->num_rows
            : 0;
    }

    public function ultimoId() {
        return $this->conexion ? $this->conexion->insert_id : null;
    }
}

?>
