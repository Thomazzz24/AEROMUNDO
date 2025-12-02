<?php
class CheckinDAO {

    private $id_checkin;
    private $id_tiquete;
    private $fecha_checkin;

    public function __construct(
        $id_checkin = 0,
        $id_tiquete = 0,
        $fecha_checkin = ""
    ){
        $this->id_checkin = $id_checkin;
        $this->id_tiquete = $id_tiquete;
        $this->fecha_checkin = $fecha_checkin;
    }

    public function insertar() {
        return "INSERT INTO p1_checkin (id_tiquete, fecha_checkin)
                VALUES ('{$this->id_tiquete}', '{$this->fecha_checkin}')";
    }

    public function consultarPorTiquete($id_tiquete) {
        return "SELECT *
                FROM p1_checkin
                WHERE id_tiquete = $id_tiquete
                LIMIT 1";
    }
}
