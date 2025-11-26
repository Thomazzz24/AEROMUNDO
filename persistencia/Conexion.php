<?php

class Conexion {
    private $conexion;
    private $resultado;
    private $charset = "utf8";

    // --- CONFIG LOCAL ---
    private $local_host = "localhost";
    private $local_db   = "aerolinea";
    private $local_user = "root";
    private $local_pass = "";

    // --- CONFIG SERVIDOR ITIUD ---
    private $server_host = "127.0.0.1";       // ITIUD usa localhost interno
    private $server_db   = "itiud_aplint2";
    private $server_user = "itiud_aplint2";
    private $server_pass = "9IGmG24ue&";

    function abrir() {
        try {

            // Detectar si estamos en local o en el servidor
            if ($_SERVER['REMOTE_ADDR'] == "::1") {

                // MODO LOCAL
                $host = $this->local_host;
                $db   = $this->local_db;
                $user = $this->local_user;
                $pass = $this->local_pass;

            } else {

                // MODO SERVIDOR ITIUD
                $host = $this->server_host;
                $db   = $this->server_db;
                $user = $this->server_user;
                $pass = $this->server_pass;
            }

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false
            ];

            $this->conexion = new PDO(
                "mysql:host={$host};dbname={$db};charset={$this->charset}",
                $user,
                $pass,
                $options
            );

        } catch (PDOException $e) {
            die("❌ Error de conexión: " . $e->getMessage());
        }
    }

    public function cerrar() {
        $this->conexion = null;
    }

    public function ejecutar($sql, $parametros = []) {
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($parametros);
            $this->resultado = $stmt;
        } catch (PDOException $e) {
            die("❌ Error en la consulta: " . $e->getMessage());
        }
    }

    public function registro() {
        return $this->resultado->fetch(PDO::FETCH_ASSOC);
    }

    public function filas() {
        return $this->resultado->rowCount();
    }
}

?>
