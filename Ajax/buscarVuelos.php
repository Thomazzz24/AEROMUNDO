<?php
session_start(); 
require_once("../logica/Vuelo.php");

$origen = isset($_GET["origen"]) ? trim($_GET["origen"]) : "";
$destino = isset($_GET["destino"]) ? trim($_GET["destino"]) : "";
$fecha = isset($_GET["fecha"]) ? trim($_GET["fecha"]) : "";

$v = new Vuelo();
$lista = $v->buscarVuelos($origen, $destino, $fecha);

if (!$lista || count($lista) == 0) {
    echo '<div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fa-solid fa-plane-slash me-2"></i>
                No se encontraron vuelos con los criterios seleccionados.
            </div>
        </div>';
    exit;
}

foreach ($lista as $vuelo) {

    $imagenes = [
        "Cartagena" => "AEROMUNDO/img/cartagena2.jpg",
        "Madrid" => "AEROMUNDO/img/madrid.webp",
        "Medellín" => "AEROMUNDO/img/medellin.jpg",
        "Cali" => "AEROMUNDO/img/cali.jpg",
        "Santa Marta" => "AEROMUNDO/img/santaMarta.jpg",
        "Pereira" => "AEROMUNDO/img/pereira.jpg",
        "Bogota" => "AEROMUNDO/img/bogota.jpg"
    ];
    $img = $imagenes[$vuelo->getDestino()] ?? "AEROMUNDO/img/default.jpg";

    $salida = date("d/m/Y H:i", strtotime($vuelo->getFecha_salida()));
    $llegada = date("d/m/Y H:i", strtotime($vuelo->getFecha_llegada()));
    $idVuelo = $vuelo->getId_vuelo();

    if (!isset($_SESSION["id"]) || $_SESSION["rol"] != "pasajero") {
        $boton = '<a href="?pid=' . base64_encode("autenticacion/autenticar.php") . '&redir=' . $idVuelo . '" 
                    class="btn btn-danger w-100">
                    <i class="fa-solid fa-plane-departure me-1"></i> Reservar vuelo
                </a>';
    } else {
        $boton = '<a href="?pid=' . base64_encode("presentacion/Pasajero/comprarTiquete.php") . '&idVuelo=' . $idVuelo . '" 
                    class="btn btn-danger w-100">
                    <i class="fa-solid fa-plane-departure me-1"></i> Reservar vuelo
                </a>';
    }

    echo '
    <div class="col">
        <div class="card h-100 shadow-sm border-0">
            <img src="../' . $img . '" class="card-img-top" style="height:200px; object-fit:cover;">

            <div class="card-body">
                <h5 class="card-title fw-bold text-danger">
                    '.$vuelo->getOrigen().' → '.$vuelo->getDestino().'
                </h5>

                <p class="card-text">
                    <strong>Fecha salida:</strong> '.$salida.'<br>
                    <strong>Fecha llegada:</strong> '.$llegada.'<br>
                    <strong>Avión:</strong> '.$vuelo->getModelo().'<br>
                    <strong>Piloto:</strong> '.$vuelo->getPiloto_principal().'<br>
                    <strong>Copiloto:</strong> '.$vuelo->getCopiloto().'
                </p>

                '.$boton.'
            </div>
        </div>
    </div>';
}
?>
