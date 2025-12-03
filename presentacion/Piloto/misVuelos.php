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
$vuelos = $vuelo->consultarPorPiloto($id_piloto);
?>
<?php include "presentacion/Piloto/menuPiloto.php"; ?>
<div class="container mt-5">

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">
                <i class="fa-solid fa-plane me-2"></i>
                Mis Vuelos Programados
            </h4>
        </div>
        <div class="card-body">

            <?php if (!$vuelos || count($vuelos) == 0) { ?>
                
                <div class="alert alert-info text-center">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    No tienes vuelos programados en este momento.
                </div>

            <?php } else { ?>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-danger text-center">
                            <tr>
                                <th>#</th>
                                <th>Ruta</th>
                                <th>Avión</th>
                                <th>Rol</th>
                                <th>Fecha Salida</th>
                                <th>Fecha Llegada</th>
                                <th>Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($vuelos as $v):
                                $rol = ($v->getId_piloto_principal() == $id_piloto) 
                                    ? "Piloto Principal" 
                                    : "Copiloto";

                                $badge_estado = '';
                                switch($v->getEstado()) {
                                    case 1:
                                        $badge_estado = '<span class="badge bg-success">Programado</span>';
                                        break;
                                    case 2:
                                        $badge_estado = '<span class="badge bg-primary">En curso</span>';
                                        break;
                                    case 3:
                                        $badge_estado = '<span class="badge bg-secondary">Completado</span>';
                                        break;
                                    default:
                                        $badge_estado = '<span class="badge bg-warning">Pendiente</span>';
                                }
                            ?>
                            <tr>
                                <td class="text-center"><?= $i++ ?></td>

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
                                            Piloto Principal
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-info text-dark">
                                            <i class="fa-solid fa-user me-1"></i>
                                            Copiloto
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <i class="fa-solid fa-plane-departure me-1 text-success"></i>
                                    <?= date("d/m/Y H:i", strtotime($v->getFecha_salida())) ?>
                                </td>

                                <td class="text-center">
                                    <i class="fa-solid fa-plane-arrival me-1 text-danger"></i>
                                    <?= date("d/m/Y H:i", strtotime($v->getFecha_llegada())) ?>
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