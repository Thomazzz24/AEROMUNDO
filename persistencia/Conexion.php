<?php

class Conexion {
    private $conexion;
    private $resultado;

    private $host;
    private $database;
    private $username;
    private $password;

    public function __construct() {

        // Detectar si estoy en local
        if ($_SERVER["HTTP_HOST"] == "localhost" || $_SERVER["HTTP_HOST"] == "127.0.0.1") {
            
            // 🔵 CONFIGURACIÓN LOCAL
            $this->host = "localhost";
            $this->database = "aeropuerto";    // <-- PON AQUÍ TU BD LOCAL
            $this->username = "root";
            $this->password = "";
        
        } else {

            // 🔶 CONFIGURACIÓN DEL SERVIDOR ITIUD
            $this->host = "localhost";
            $this->database = "itiud_aplint2";
            $this->username = "itiud_aplint2";
            $this->password = "9IGmG24ue&";
        }
    }

    public function abrir() {

        $this->conexion = @new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if ($this->conexion->connect_errno) {
            die("❌ Error de conexión: " . $this->conexion->connect_error);
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
            die("❌ Error SQL: " . $this->conexion->error . "<br>📌 Consulta: $sentencia");
        }
    }

    public function registro() {
        return ($this->resultado instanceof mysqli_result)
            ? $this->resultado->fetch_assoc()
            : null;
    }

    public function extraer() {
        return ($this->resultado instanceof mysqli_result)
            ? $this->resultado->fetch_row()
            : null;
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

