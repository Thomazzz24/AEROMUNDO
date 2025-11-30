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
        return "INSERT INTO p1_avion (modelo, capacidad, estado)
                VALUES ('{$this->modelo}', {$this->capacidad}, {$this->estado})";
    }

    public function consultarPorId() {
        return "SELECT id_avion, modelo, capacidad, estado
                FROM p1_avion
                WHERE id_avion = {$this->id}";
    }

    public function consultarTodos() {
        return "SELECT id_avion, modelo, capacidad, estado
                FROM p1_avion";
    }

    public function editar() {
        return "UPDATE p1_avion
                SET modelo = '{$this->modelo}',
                    capacidad = {$this->capacidad},
                    estado = {$this->estado}
                WHERE id_avion = {$this->id}";
    }

    public function cambiarEstado() {
        return "UPDATE p1_avion
                SET estado = {$this->estado}
                WHERE id_avion = {$this->id}";
    }

    public function eliminar() {
        return "DELETE FROM p1_avion
                WHERE id_avion = {$this->id}";
    }

    public function avionesMasUsados() {
    return "SELECT 
                a.modelo as avion,
                COUNT(*) as cantidad
            FROM p1_vuelo v
            INNER JOIN p1_avion a ON v.id_avion = a.id_avion
            GROUP BY a.id_avion, a.modelo
            ORDER BY cantidad DESC
            LIMIT 10";
}

    
}
