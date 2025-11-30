<?php

class RutaDAO {
    private $id;
    private $origen;
    private $destino;
    private $duracion;

    public function __construct($id, $origen, $destino, $duracion) {
        $this->id = $id;
        $this->origen = $origen;
        $this->destino = $destino;
        $this->duracion = $duracion;
    }

    public function registrar() {
        return "INSERT INTO p1_ruta (origen, destino, duracion_estimada)
                VALUES ('{$this->origen}', '{$this->destino}', '{$this->duracion}')";
    }

    public function consultarPorId() {
        return "SELECT id_ruta, origen, destino, duracion_estimada
                FROM p1_ruta
                WHERE id_ruta = {$this->id}";
    }

    public function consultarTodos() {
        return "SELECT id_ruta, origen, destino, duracion_estimada
                FROM p1_ruta";
    }

    public function editar() {
        return "UPDATE p1_ruta
                SET origen = '{$this->origen}',
                    destino = '{$this->destino}',
                    duracion_estimada = {$this->duracion}
                WHERE id_ruta = {$this->id}";
    }

    public function eliminar() {
        return "DELETE FROM p1_ruta
                WHERE id_ruta = {$this->id}";
    }

    public function obtenerRutas() {
        return "SELECT DISTINCT origen, destino
                FROM p1_ruta
                ORDER BY origen ASC, destino ASC
        ";
    }

    public function rutasMasUsadas() {
        return "SELECT 
                    CONCAT(r.origen, ' → ', r.destino) as ruta,
                    COUNT(*) as cantidad
                FROM p1_vuelo v
                INNER JOIN p1_ruta r ON v.id_ruta = r.id_ruta
                GROUP BY r.id_ruta, r.origen, r.destino
                ORDER BY cantidad DESC
                LIMIT 10";
    }
}
