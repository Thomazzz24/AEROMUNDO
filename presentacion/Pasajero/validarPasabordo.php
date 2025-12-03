<?php
session_start();

if (!isset($_SESSION["id"]) || $_SESSION["rol"] != "pasajero") {
    die("Acceso no autorizado");
}

if (!isset($_GET["id_tiquete"]) || !is_numeric($_GET["id_tiquete"])) {
    die("Tiquete no válido");
}

$id_tiquete = $_GET["id_tiquete"];

require_once("../../logica/Tiquete.php");
require_once("../../logica/Vuelo.php");

$t = new Tiquete($id_tiquete);

if (!$t->consultarPorId()) {
    die("Tiquete no encontrado");
}

// Datos del tiquete
$asiento = $t->getAsiento();
$nombre = $t->getNombre_pasajero();
$documento = $t->getDocumento();
$id_vuelo = $t->getId_vuelo();

// Obtener el vuelo
$v = new Vuelo($id_vuelo);
$v->consultarPorId();

// Datos del vuelo
$origen     = $v->getOrigen();
$destino    = $v->getDestino();
$fecha      = $v->getFecha_salida();
$hora       = date("H:i", strtotime($v->getFecha_salida()));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validar Pasabordo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-4">

    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Validación del Pasabordo</h3>
            <small>Información completa del vuelo y del pasajero</small>
        </div>

        <div class="card-body">

            <!-- PASAJERO -->
            <h5 class="mb-3">👤 Información del pasajero</h5>
            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>Nombre:</strong> <?= htmlspecialchars($nombre) ?></li>
                <li class="list-group-item"><strong>Documento:</strong> <?= htmlspecialchars($documento) ?></li>
                <li class="list-group-item"><strong>Asiento:</strong> <?= htmlspecialchars($asiento) ?></li>
                <li class="list-group-item"><strong>ID del Tiquete:</strong> <?= $id_tiquete ?></li>
            </ul>

            <!-- VUELO -->
            <h5 class="mb-3">✈️ Información del vuelo</h5>
            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>Origen:</strong> <?= htmlspecialchars($origen) ?></li>
                <li class="list-group-item"><strong>Destino:</strong> <?= htmlspecialchars($destino) ?></li>
                <li class="list-group-item"><strong>Fecha de salida:</strong> <?= date("d/m/Y", strtotime($fecha)) ?></li>
                <li class="list-group-item"><strong>Hora de salida:</strong> <?= $hora ?></li>
                <li class="list-group-item"><strong>Código del vuelo:</strong> <?= $id_vuelo ?></li>
            </ul>

            <div class="d-flex justify-content-between">

                <!-- Botón ver pasabordo PDF -->
                <a href="verPasabordo.php?id=<?= $id_tiquete ?>" class="btn btn-success btn-lg">
                    📄 Ver pasabordo (PDF)
                </a>

                <!-- Botón volver -->
                <a href="../inicio.php" class="btn btn-secondary btn-lg">
                    ⬅ Volver
                </a>

            </div>

        </div>
    </div>

</div>

</body>
</html>
