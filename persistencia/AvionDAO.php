<?php

class AvionDAO {
    private $id;
    private $modelo;
    private $capacidad;
    private $estado;

    public function __construct($id, $modelo, $capacidad, $estado) {
        $this->id = $id;
        $this->modelo = $modelo;
        $this->capacidad = $capacidad;
        $this->estado = $estado;
    }

    public function registrar() {
        return "INSERT INTO avion (modelo, capacidad, estado)
                VALUES ('{$this->modelo}', {$this->capacidad}, {$this->estado})";
    }

    public function consultarPorId() {
        return "SELECT id_avion, modelo, capacidad, estado
                FROM avion
                WHERE id_avion = {$this->id}";
    }

    public function consultarTodos() {
        return "SELECT id_avion, modelo, capacidad, estado
                FROM avion";
    }

    public function editar() {
        return "UPDATE avion
                SET modelo = '{$this->modelo}',
                    capacidad = {$this->capacidad},
                    estado = {$this->estado}
                WHERE id_avion = {$this->id}";
    }

    public function cambiarEstado() {
        return "UPDATE avion
                SET estado = {$this->estado}
                WHERE id_avion = {$this->id}";
    }

    public function eliminar() {
        return "DELETE FROM avion
                WHERE id_avion = {$this->id}";
    }

    
}
