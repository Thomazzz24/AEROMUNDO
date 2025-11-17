<?php
if (!isset($_SESSION["id"]) || $_SESSION["rol"] != "admin") {
    header("Location: ?pid=" . base64_encode("noAutorizado.php"));
}
include_once("logica/Admin.php");

$admin = new Admin($_SESSION["id"]);
$admin->consultarPorId();

include("administrador/sesionAdmin.php");  
include_once("logica/Avion.php");             

$avion = new Avion();
$listaAviones = $avion->consultarTodos();
?>

<div class="container mt-4">
    <h3>Listado de Aviones</h3>
    <hr>

    <?php if (count($listaAviones) > 0) { ?>
        <table class="table table-striped table-hover table-bordered">
            <thead class="table-danger">
                <tr>
                    <th>ID</th>
                    <th>Modelo</th>
                    <th>Capacidad</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($listaAviones as $a) { ?>
                    <tr>
                        <td><?= $a->getId() ?></td>
                        <td><?= $a->getModelo() ?></td>
                        <td><?= $a->getCapacidad() ?></td>
                        <td>
                            <?= $a->getEstado() == 1 ? "<span class='badge bg-success'>Activo</span>" : "<span class='badge bg-danger'>Inactivo</span>" ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="alert alert-warning">
            No hay aviones registrados.
        </div>
    <?php } ?>
</div>
