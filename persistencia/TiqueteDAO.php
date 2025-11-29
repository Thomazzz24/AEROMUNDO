<?php
class TiqueteDAO {

    private $idTiquete;
    private $idComprador;
    private $idVuelo;
    private $idPasajero;
    private $nombrePasajero;
    private $documento;
    private $asiento;
    private $precio;

    public function __construct(
        $idTiquete = 0,
        $idComprador = 0,
        $idVuelo = 0,
        $idPasajero = 0,
        $nombrePasajero = "",
        $documento = "",
        $asiento = "",
        $precio = 0
    ){
        $this->idTiquete = $idTiquete;
        $this->idComprador = $idComprador;
        $this->idVuelo = $idVuelo;
        $this->idPasajero = $idPasajero;
        $this->nombrePasajero = $nombrePasajero;
        $this->documento = $documento;
        $this->asiento = $asiento;
        $this->precio = $precio;
    }

 public function insertar(){

    // Manejo correcto del NULL para id_pasajero
    $idPasajeroSQL = ($this->idPasajero === null || $this->idPasajero === 0)
        ? "NULL"
        : "'{$this->idPasajero}'";

    return "
        INSERT INTO p1_tiquete (
            id_comprador,
            id_vuelo,
            id_pasajero,
            nombre_pasajero,
            documento,
            asiento,
            precio,
            fecha_compra
        ) VALUES (
            '{$this->idComprador}',
            '{$this->idVuelo}',
            $idPasajeroSQL,
            '{$this->nombrePasajero}',
            '{$this->documento}',
            '{$this->asiento}',
            '{$this->precio}',
            NOW()
        )
    ";
}

    public function consultar(){
        return "
            SELECT * FROM p1_tiquete
            WHERE id_tiquete = '{$this->idTiquete}'
        ";
    }

    public function consultarTodos(){
        return "
            SELECT * FROM p1_tiquete
            ORDER BY id_tiquete DESC
        ";
    }
}
?>
