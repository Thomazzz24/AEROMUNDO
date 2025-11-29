<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once("logica/Vuelo.php");
require_once("logica/Tiquete.php");
require_once("logica/Pasajero.php");
include "menuPasajero.php"; 


$idVuelo = $_GET["idVuelo"];

$vuelo = new Vuelo($idVuelo);
$vuelo->consultarPorId();

$comprador = new Pasajero($_SESSION["id"]);
$comprador->consultarPorId();

if (isset($_POST["comprar"])) {
    
    $nombres = $_POST["pasajeros"];
    $documentos = $_POST["documentos"];

    for ($i = 0; $i < count($nombres); $i++) {

        $asiento = rand(1, 30) . chr(rand(65, 68)); // ejemplo: 12A, 22B

        // Si el pasajero es el mismo comprador:
        $idPasajero = null;
        $nombreForm = trim($nombres[$i]);

        $nombreComprador = trim($comprador->getNombre() . " " . $comprador->getApellido());

        if (strtolower($nombreForm) == strtolower($nombreComprador)) {
            $idPasajero = $comprador->getId();
        }

        $tiquete = new Tiquete(
            0,
            $comprador->getId(),   // id_comprador
            $idVuelo,
            $idPasajero,           // id_pasajero o NULL si es invitado
            $nombres[$i],
            $documentos[$i],
            $asiento,
            $vuelo->getPrecio()
        );

        $tiquete->insertar();
    }

    echo "<div class='alert alert-success mt-3'>Compra realizada exitosamente.</div>";
} 
?>

<div class="container mt-4">
    <h2>Comprar Tiquete</h2>

    <p><strong>Vuelo:</strong> 
        <?= $vuelo->getOrigen() . " → " . $vuelo->getDestino(); ?>
    </p>

    <p><strong>Salida:</strong> <?= $vuelo->getFecha_salida(); ?></p>

    <form method="POST">

        <h4>Pasajeros</h4>
        <div id="contenedorPasajeros">

            <div class="row mb-3">
                <div class="col">
                    <input type="text" name="pasajeros[]" class="form-control"
                        value="<?= $comprador->getNombre() . ' ' . $comprador->getApellido(); ?>">
                </div>
                <div class="col">
                    <input type="text" name="documentos[]" class="form-control"
                        placeholder="Documento" required>
                </div>
            </div>

        </div>

        <button type="button" class="btn btn-secondary mb-3" onclick="agregarPasajero()">
            Añadir otro pasajero
        </button>

        <button class="btn btn-danger" type="submit" name="comprar">
            Confirmar compra
        </button>

    </form>
</div>

<script>
function agregarPasajero() {
    let div = document.createElement("div");
    div.className = "row mb-3";
    div.innerHTML = `
        <div class="col">
            <input type="text" name="pasajeros[]" class="form-control" placeholder="Nombre">
        </div>
        <div class="col">
            <input type="text" name="documentos[]" class="form-control" placeholder="Documento">
        </div>`;
    document.getElementById("contenedorPasajeros").appendChild(div);
}
</script>
