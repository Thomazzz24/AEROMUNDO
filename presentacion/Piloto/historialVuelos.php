<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("logica/Vuelo.php");
require_once("logica/Piloto.php");

if (!isset($_SESSION["id"]) || $_SESSION["rol"] != "piloto") {
    header("Location: ?pid=" . base64_encode("presentacion/autenticacion/autenticar.php"));
    exit();
}

$piloto = new Piloto($_SESSION["id"]);
$piloto->consultarPorId();

$id_piloto = $piloto->obtenerIdPiloto();

$vuelo = new Vuelo();
$historial = $vuelo->consultarHistorialPorPiloto($id_piloto);
?>
<?php include "presentacion/Piloto/menuPiloto.php"; ?>
<div class="container mt-5">

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">
                <i class="fa-solid fa-clock-rotate-left me-2"></i>
                Historial de Vuelos
            </h4>
        </div>
        <div class="card-body">

            <?php if (!$historial || count($historial) == 0) { ?>
                
                <div class="alert alert-info text-center">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    No tienes vuelos completados en tu historial.
                </div>

            <?php } else { ?>


                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-danger text-center">
                            <tr>
                                <th>#</th>
                                <th>Fecha</th>
                                <th>Ruta</th>
                                <th>Avión</th>
                                <th>Rol</th>
                                <th>Salida</th>
                                <th>Llegada</th>
                                <th>Duración</th>
                                <th>Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($historial as $v):
                                $rol = ($v->getId_piloto_principal() == $id_piloto) 
                                    ? "Piloto Principal" 
                                    : "Copiloto";

                                $badge_estado = '<span class="badge bg-success">Completado</span>';

                                $salida = strtotime($v->getFecha_salida());
                                $llegada = strtotime($v->getFecha_llegada());
                                $duracion_minutos = ($llegada - $salida) / 60;
                                $horas = floor($duracion_minutos / 60);
                                $minutos = $duracion_minutos % 60;
                                $duracion_texto = $horas . "h " . $minutos . "m";
                            ?>
                            <tr>
                                <td class="text-center"><?= $i++ ?></td>

                                <td class="text-center">
                                    <strong><?= date("d/m/Y", strtotime($v->getFecha_salida())) ?></strong>
                                </td>

                                <td>
                                    <strong><?= $v->getOrigen() ?></strong>
                                    <i class="fa-solid fa-arrow-right mx-2 text-danger"></i>
                                    <strong><?= $v->getDestino() ?></strong>
                                </td>

                                <td class="text-center">
                                    <i class="fa-solid fa-jet-fighter me-1"></i>
                                    <?= $v->getModelo() ?>
                                </td>

                                <td class="text-center">
                                    <?php if($rol == "Piloto Principal"): ?>
                                        <span class="badge bg-primary">
                                            <i class="fa-solid fa-star me-1"></i>
                                            Principal
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-info text-dark">
                                            <i class="fa-solid fa-user me-1"></i>
                                            Copiloto
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <small class="text-muted">
                                        <i class="fa-solid fa-plane-departure me-1"></i>
                                        <?= date("H:i", strtotime($v->getFecha_salida())) ?>
                                    </small>
                                </td>

                                <td class="text-center">
                                    <small class="text-muted">
                                        <i class="fa-solid fa-plane-arrival me-1"></i>
                                        <?= date("H:i", strtotime($v->getFecha_llegada())) ?>
                                    </small>
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-secondary">
                                        <?= $duracion_texto ?>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <?= $badge_estado ?>
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