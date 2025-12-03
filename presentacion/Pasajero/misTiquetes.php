<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("logica/tiquete.php");
require_once("logica/Pasajero.php");
require_once("logica/Vuelo.php");
require_once("logica/Checkin.php");

if (!isset($_SESSION["id"]) || $_SESSION["rol"] != "pasajero") {
    header("Location: ?pid=" . base64_encode("autenticacion/autenticar.php"));
    exit();
}

include "presentacion/Pasajero/menuPasajero.php";

$pasajero = new Pasajero($_SESSION["id"]);
$pasajero->consultarPorId();

$tiquete = new Tiquete();
$tiquetes = $tiquete->consultarPorPasajero($pasajero->getId());
?>

<div class="container mt-5">

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">
                <i class="fa-solid fa-ticket me-2"></i>
                Mis Tiquetes
            </h4>
        </div>
        <div class="card-body">

            <?php if (!$tiquetes || count($tiquetes) == 0) { ?>
                
                <div class="alert alert-info text-center">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    No tienes tiquetes comprados aún.
                </div>

                <div class="text-center mt-4">
                    <a href="?pid=<?= base64_encode('presentacion/Pasajero/comprarVuelo.php') ?>" 
                        class="btn btn-primary">
                        <i class="fa-solid fa-plane-up me-2"></i> Buscar vuelos
                    </a>
                </div>

            <?php } else { ?>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-danger text-center">
                            <tr>
                                <th>#</th>
                                <th>Vuelo</th>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Fecha Salida</th>
                                <th>Asiento</th>
                                <th>Documento</th>
                                <th>Check-In</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 1;

                            foreach ($tiquetes as $t):

                                $vuelo = new Vuelo($t->getId_vuelo());
                                $vuelo->consultarPorId();

                                $checkin = new Checkin();
                                $yaCheckin = $checkin->consultarPorTiquete($t->getId_tiquete());
                            ?>
                            <tr>
                                <td class="text-center"><?= $i++ ?></td>

                                <td class="text-center">#<?= $t->getId_vuelo() ?></td>

                                <td class="text-center"><?= $vuelo->getOrigen() ?></td>

                                <td class="text-center"><?= $vuelo->getDestino() ?></td>

                                <td class="text-center">
                                    <?= date("d/m/Y H:i", strtotime($vuelo->getFecha_salida())) ?>
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-primary"><?= $t->getAsiento() ?></span>
                                </td>

                                <td class="text-center"><?= $t->getDocumento() ?></td>

                                <td class="text-center">
                                    <?php if ($yaCheckin): ?>
                                        <span class="badge bg-success">Realizado</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    <?php endif; ?>
                                </td>

                            <td class="text-center">

    <?php
    $ahora = time();
    $salida = strtotime($vuelo->getFecha_salida());
    $falta = $salida - $ahora;

    $puedeCheckin = ($falta <= 24 * 3600 && $falta > 0);
    ?>

<?php if ($yaCheckin): ?>
    <a href="presentacion/Pasajero/generarPasabordo.php?id_tiquete=<?= $t->getId_tiquete() ?>" 
        target="_blank" 
        class="btn btn-success btn-sm">
        <i class="fa-solid fa-file-pdf me-1"></i>
        Ver Pasabordo
    </a>

    <?php elseif ($puedeCheckin): ?>


<a href="?pid=<?= base64_encode('presentacion/Pasajero/hacerChekin.php') ?>&id_tiquete=<?= $t->getId_tiquete() ?>"
    class="btn btn-primary btn-sm">
    <i class="fa-solid fa-check me-1"></i>
    Hacer Check-In
</a>

    <?php else: ?>
        <button class="btn btn-secondary btn-sm" disabled>
            <i class="fa-solid fa-clock me-1"></i>
            Aún no disponible
        </button>
    <?php endif; ?>

</td>
                            </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php } ?>

        </div>
    </div>

</div>
