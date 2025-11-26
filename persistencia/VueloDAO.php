<?php
class VueloDAO {

    private $id_vuelo;
    private $id_ruta;
    private $id_avion;
    private $id_piloto_principal;
    private $id_copiloto;
    private $fecha_salida;
    private $fecha_llegada;
    private $estado;
    
    // Variables adicionales para mostrar datos del JOIN
    private $origen;
    private $destino;
    private $modelo;

    function __construct(
        $id_vuelo = "",
        $id_ruta = "",
        $id_avion = "",
        $id_piloto_principal = "",
        $id_copiloto = "",
        $fecha_salida = "",
        $fecha_llegada = "",
        $estado = ""
    ) {
        $this->id_vuelo = $id_vuelo;
        $this->id_ruta = $id_ruta;
        $this->id_avion = $id_avion;
        $this->id_piloto_principal = $id_piloto_principal; 
        $this->id_copiloto = $id_copiloto;
        $this->fecha_salida = $fecha_salida;
        $this->fecha_llegada = $fecha_llegada;
        $this->estado = $estado;
    }

    public function registrar() {
        return "INSERT INTO p1_vuelo
                (id_ruta, id_avion, id_piloto_principal, id_copiloto, fecha_salida, fecha_llegada, estado)
                VALUES (
                    '{$this->id_ruta}',
                    '{$this->id_avion}',
                    '{$this->id_piloto_principal}',
                    '{$this->id_copiloto}',
                    '{$this->fecha_salida}',
                    '{$this->fecha_llegada}',
                    '{$this->estado}'
                )";
    }

    public function consultarPorId() {
        return "SELECT 
                    id_vuelo,
                    id_ruta,
                    id_avion,
                    id_piloto_principal,
                    id_copiloto,
                    fecha_salida,
                    fecha_llegada,
                    estado
                FROM p1_vuelo
                WHERE id_vuelo = {$this->id_vuelo}";
    }

    function consultarTodos() {
        return "SELECT 
                v.id_vuelo,
                v.id_ruta,
                v.id_avion,
                v.id_piloto_principal,
                v.id_copiloto,
                r.origen,
                r.destino,
                a.modelo,
                v.fecha_salida,
                v.fecha_llegada,
                v.estado,
                CONCAT(u1.nombre, ' ', u1.apellido) AS piloto_principal,
                CONCAT(u2.nombre, ' ', u2.apellido) AS copiloto
            FROM p1_vuelo v

            INNER JOIN p1_ruta r ON v.id_ruta = r.id_ruta
            INNER JOIN p1_avion a ON v.id_avion = a.id_avion

            INNER JOIN p1_piloto p1 ON v.id_piloto_principal = p1.id_piloto
            INNER JOIN p1_usuario u1 ON p1.id_usuario = u1.id_usuario
            LEFT JOIN p1_piloto p2 ON v.id_copiloto = p2.id_piloto
            LEFT JOIN p1_usuario u2 ON p2.id_usuario = u2.id_usuario

            ORDER BY v.fecha_salida ASC;";
    }

    public function editar() {
        return "UPDATE p1_vuelo SET
                    id_ruta = '{$this->id_ruta}',
                    id_avion = '{$this->id_avion}',
                    id_piloto_principal = '{$this->id_piloto_principal}',
                    id_copiloto = '{$this->id_copiloto}',
                    fecha_salida = '{$this->fecha_salida}',
                    fecha_llegada = '{$this->fecha_llegada}',
                    estado = '{$this->estado}'
                WHERE id_vuelo = {$this->id_vuelo}";
    }

    public function eliminar() {
        return "DELETE FROM p1_vuelo
                WHERE id_vuelo = {$this->id_vuelo}";
    }

    public function avionDisponible($fecha_salida, $fecha_llegada) {
        return "SELECT a.id_avion, a.modelo, a.capacidad
                FROM p1_avion a
                WHERE a.estado = 1
                AND a.id_avion NOT IN (
                    SELECT v.id_avion
                    FROM p1_vuelo v
                    WHERE v.fecha_salida <= '$fecha_llegada'
                    AND v.fecha_llegada >= '$fecha_salida'
                    )
                    ORDER BY a.modelo ASC";
    }

    public function pilotoDisponible($fecha_salida, $fecha_llegada) {
        return "SELECT p.id_piloto, u.nombre, u.apellido
                FROM p1_piloto p
                INNER JOIN p1_usuario u ON p.id_usuario = u.id_usuario
                WHERE u.estado = 1
                AND p.id_piloto NOT IN (
                    SELECT v.id_piloto_principal 
                    FROM p1_vuelo v 
                    WHERE (fecha_salida <= '$fecha_llegada' AND fecha_llegada >= '$fecha_salida')
                )
                AND p.id_piloto NOT IN (
                    SELECT v.id_copiloto 
                    FROM p1_vuelo v 
                    WHERE (v.fecha_salida <= '$fecha_llegada' AND v.fecha_llegada >= '$fecha_salida')
                )";
    }

}
