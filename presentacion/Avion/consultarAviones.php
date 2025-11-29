<?php
require_once ("logica/Avion.php");
require_once ("logica/Admin.php");

if (!isset($_SESSION["id"]) || $_SESSION["rol"] != "admin") {
    header("Location: ?pid=" . base64_encode("noAutorizado.php"));
    exit();
}

$admin = new Admin($_SESSION["id"]);
$admin->consultarPorId();

$avion = new Avion();
$listaAviones = $avion->consultarTodos();

$mensaje = "";
if(isset($_GET["eliminar"])){
    $idAvionAEliminar = $_GET["eliminar"];
    $avionAEliminar = new Avion($idAvionAEliminar);
    $avionAEliminar->eliminar();
    $mensaje = "<div class='alert alert-success mt-3 text-center' role='alert'>
                    Avión eliminado exitosamente.
                </div>";
}

?>
<body>
<?php include 'presentacion/administrador/menuAdministrador.php'; ?>
<div class="container mt-4">
    <h3>Listado de Aviones</h3>
    <hr>
    <?php if($mensaje != "") echo $mensaje; ?>

    <?php if (count($listaAviones) > 0) { ?>
    <table class="table table-striped table-hover table-bordered">
        <thead class="table-danger">
            <tr>
                <th>ID</th>
                <th>Modelo</th>
                <th>Capacidad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($listaAviones as $a) { ?>
            <tr>
                <td><?= $a->getId() ?></td>
                <td><?= $a->getModelo() ?></td>
                <td><?= $a->getCapacidad() ?></td>
                <td id="estado<?= $a->getId() ?>">
                    <?= $a->getEstado() == 1 
                        ? "<button class='btn btn-success btn-sm'>Activo</button>"  
                        : "<button class='btn btn-warning btn-sm'>Mantenimiento</button>" ?>
                </td>
                <td>
                    <div class="d-flex justify-content-center gap-2">

                        <!-- Activar -->
                        <div id="habilitar<?= $a->getId() ?>" <?= $a->getEstado() == 1 ? "style='display:none'" : "" ?>>
                            <a href="#" title="Habilitar">
                                <i class="fa-regular fa-circle-check text-success fs-3"></i>
                            </a>
                        </div>

                        <!-- Desactivar -->
                        <div id="deshabilitar<?= $a->getId() ?>" <?= $a->getEstado() == 1 ? "" : "style='display:none'" ?>>
                            <a href="#" title="Deshabilitar">
                                <i class="fa-regular fa-circle-xmark text-danger fs-3"></i>
                            </a>
                        </div>

                        <!-- Editar -->
                        <a href='?pid=<?= base64_encode("presentacion/Avion/editarAvion.php") ?>&idAvion=<?= $a->getId() ?>' title='Editar'>
                            <i class='fa-solid fa-pen-to-square text-primary fs-4'></i>
                        </a>

                        <!-- Eliminar -->
                        <a href='?pid=<?= base64_encode("presentacion/Avion/consultarAviones.php") ?>&eliminar=<?= $a->getId() ?>' 
                           title='Eliminar' onclick='return confirm("¿Seguro que deseas eliminar este avión?")'>
                            <i class='fa-solid fa-trash text-danger fs-4'></i>
                        </a>
                    </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
<?php foreach ($listaAviones as $a) { ?>
    $("#habilitar<?= $a->getId() ?> a").on("click", function(e) {
        e.preventDefault();
        var url = "cambiarEstadoAvionAjax.php?idAvion=<?= $a->getId() ?>&estado=1";
        $("#estado<?= $a->getId() ?>").load(url);
        $("#habilitar<?= $a->getId() ?>").hide();
        $("#deshabilitar<?= $a->getId() ?>").show();
    });

    $("#deshabilitar<?= $a->getId() ?> a").on("click", function(e) {
        e.preventDefault();
        var url = "cambiarEstadoAvionAjax.php?idAvion=<?= $a->getId() ?>&estado=0";
        $("#estado<?= $a->getId() ?>").load(url);
        $("#deshabilitar<?= $a->getId() ?>").hide();
        $("#habilitar<?= $a->getId() ?>").show();
    });
<?php } ?>
</script>
</body>
