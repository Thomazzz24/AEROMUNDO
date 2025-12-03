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
    private $precio;

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
        $estado = "",
        $precio = ""
    ) {
        $this->id_vuelo = $id_vuelo;
        $this->id_ruta = $id_ruta;
        $this->id_avion = $id_avion;
        $this->id_piloto_principal = $id_piloto_principal;
        $this->id_copiloto = $id_copiloto;
        $this->fecha_salida = $fecha_salida;
        $this->fecha_llegada = $fecha_llegada;
        $this->estado = $estado;
        $this->precio = $precio;
    }

    public function registrar() {
        return "INSERT INTO p1_vuelo
                (id_ruta, id_avion, id_piloto_principal, id_copiloto, fecha_salida, fecha_llegada, estado, precio)
                VALUES (
                    '{$this->id_ruta}',
                    '{$this->id_avion}',
                    '{$this->id_piloto_principal}',
                    '{$this->id_copiloto}',
                    '{$this->fecha_salida}',
                    '{$this->fecha_llegada}',
                    '{$this->estado}',
                    '{$this->precio}'
                )";
    }

    public function consultarPorId() {
        return "
        SELECT 
            v.id_vuelo,
            v.id_ruta,
            v.id_avion,
            v.id_piloto_principal,
            v.id_copiloto,
            v.fecha_salida,
            v.fecha_llegada,
            v.estado,
            v.precio,
            r.origen,
            r.destino,
            a.modelo,
            CONCAT(u1.nombre, ' ', u1.apellido) AS piloto_principal,
            CONCAT(u2.nombre, ' ', u2.apellido) AS copiloto
        FROM p1_vuelo v
        INNER JOIN p1_ruta r ON v.id_ruta = r.id_ruta
        INNER JOIN p1_avion a ON v.id_avion = a.id_avion
        INNER JOIN p1_piloto p1 ON v.id_piloto_principal = p1.id_piloto
        INNER JOIN p1_usuario u1 ON p1.id_usuario = u1.id_usuario
        LEFT JOIN p1_piloto p2 ON v.id_copiloto = p2.id_piloto
        LEFT JOIN p1_usuario u2 ON p2.id_usuario = u2.id_usuario
        WHERE v.id_vuelo = {$this->id_vuelo}
        ";
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
                v.precio,
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
                    estado = '{$this->estado}',
                    precio = '{$this->precio}'
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

    public function consultarProximosVuelos() {
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
                    v.precio,
                    CONCAT(u1.nombre, ' ', u1.apellido) AS piloto_principal,
                    CONCAT(u2.nombre, ' ', u2.apellido) AS copiloto
                FROM p1_vuelo v
                INNER JOIN p1_ruta r ON v.id_ruta = r.id_ruta
                INNER JOIN p1_avion a ON v.id_avion = a.id_avion
                INNER JOIN p1_piloto p1 ON v.id_piloto_principal = p1.id_piloto
                INNER JOIN p1_usuario u1 ON p1.id_usuario = u1.id_usuario
                LEFT JOIN p1_piloto p2 ON v.id_copiloto = p2.id_piloto
                LEFT JOIN p1_usuario u2 ON p2.id_usuario = u2.id_usuario
                WHERE v.fecha_salida >= NOW()
                ORDER BY v.fecha_salida ASC";
    }

    public function buscarVuelos($origen, $destino, $fecha)
    {
        $condiciones = [];

        if ($origen != "") {
            $condiciones[] = "r.origen = '$origen'";
        }

        if ($destino != "") {
            $condiciones[] = "r.destino = '$destino'";
        }

        if ($fecha != "") {
            $condiciones[] = "DATE(v.fecha_salida) = '$fecha'";
        }

        $where = "";
        if (count($condiciones) > 0) {
            $where = "WHERE " . implode(" AND ", $condiciones);
        }

        return "SELECT
                v.id_vuelo,
                v.id_ruta,
                v.id_avion,
                v.fecha_salida,
                v.fecha_llegada,
                v.estado,
                v.precio,
                r.origen,
                r.destino,
                a.modelo,
                CONCAT(u1.nombre, ' ', u1.apellido) AS piloto_principal,
                CONCAT(u2.nombre, ' ', u2.apellido) AS copiloto
            FROM p1_vuelo v
            INNER JOIN p1_ruta r ON v.id_ruta = r.id_ruta
            INNER JOIN p1_avion a ON v.id_avion = a.id_avion
            INNER JOIN p1_piloto p1 ON v.id_piloto_principal = p1.id_piloto
            INNER JOIN p1_usuario u1 ON p1.id_usuario = u1.id_usuario
            LEFT JOIN p1_piloto p2 ON v.id_copiloto = p2.id_piloto
            LEFT JOIN p1_usuario u2 ON p2.id_usuario = u2.id_usuario
            $where
            ORDER BY v.fecha_salida ASC
        ";
    }
    public function consultarPorPiloto($id_piloto) {
        return "SELECT v.*, 
                r.origen, r.destino, 
                a.modelo,
                CONCAT(u1.nombre, ' ', u1.apellido) as piloto_principal,
                CONCAT(u2.nombre, ' ', u2.apellido) as copiloto
                FROM p1_vuelo v
                INNER JOIN p1_ruta r ON v.id_ruta = r.id_ruta
                INNER JOIN p1_avion a ON v.id_avion = a.id_avion
                LEFT JOIN p1_piloto pi1 ON v.id_piloto_principal = pi1.id_piloto
                LEFT JOIN p1_usuario u1 ON pi1.id_usuario = u1.id_usuario
                LEFT JOIN p1_piloto pi2 ON v.id_copiloto = pi2.id_piloto
                LEFT JOIN p1_usuario u2 ON pi2.id_usuario = u2.id_usuario
                WHERE (v.id_piloto_principal = $id_piloto OR v.id_copiloto = $id_piloto)
                AND v.fecha_salida >= NOW()
                ORDER BY v.fecha_salida ASC";
    }
    public function consultarHistorialPorPiloto($id_piloto) {
        return "SELECT v.*, 
                r.origen, r.destino, 
                a.modelo,
            CONCAT(u1.nombre, ' ', u1.apellido) as piloto_principal,
            CONCAT(u2.nombre, ' ', u2.apellido) as copiloto
            FROM p1_vuelo v
            INNER JOIN p1_ruta r ON v.id_ruta = r.id_ruta
            INNER JOIN p1_avion a ON v.id_avion = a.id_avion
            LEFT JOIN p1_piloto pi1 ON v.id_piloto_principal = pi1.id_piloto
            LEFT JOIN p1_usuario u1 ON pi1.id_usuario = u1.id_usuario
            LEFT JOIN p1_piloto pi2 ON v.id_copiloto = pi2.id_piloto
            LEFT JOIN p1_usuario u2 ON pi2.id_usuario = u2.id_usuario
            WHERE (v.id_piloto_principal = $id_piloto OR v.id_copiloto = $id_piloto)
            AND v.fecha_llegada < NOW()
            ORDER BY v.fecha_salida DESC";
    }
}