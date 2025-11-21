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
        return "INSERT INTO ruta (origen, destino, duracion_estimada)
                VALUES ('{$this->origen}', '{$this->destino}', '{$this->duracion}')";
    }

    public function consultarPorId() {
        return "SELECT id_ruta, origen, destino, duracion_estimada
                FROM ruta
                WHERE id_ruta = {$this->id}";
    }

    public function consultarTodos() {
        return "SELECT id_ruta, origen, destino, duracion_estimada
                FROM ruta";
    }

    public function editar() {
        return "UPDATE ruta
                SET origen = '{$this->origen}',
                    destino = '{$this->destino}',
                    duracion_estimada = {$this->duracion}
                WHERE id_ruta = {$this->id}";
    }

    public function eliminar() {
        return "DELETE FROM ruta
                WHERE id_ruta = {$this->id}";
    }
}
