<?php 
require_once("logica/Piloto.php");
$piloto = new Piloto();
$pilotos = $piloto->consultarTodos();

$id = $_SESSION["id"];
if ($_SESSION["rol"] != "admin") {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
    exit();
}
$admin = new Admin($id);
$admin->consultarPorId();
$mensaje = "";

if(isset($_GET["eliminar"])){
    $idPilotoAEliminar = $_GET["eliminar"];
    $pilotoAEliminar = new Piloto($idPilotoAEliminar);
    $pilotoAEliminar->eliminar();
    $mensaje = "<div class='alert alert-success' mt-3 text-center role='alert'>
                    Piloto eliminado exitos amente.
                </div>";
}
$piloto = new Piloto();
$pilotos = $piloto->consultarTodos();
?>
<body>
<?php include 'presentacion/administrador/menuAdministrador.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="container">
    <?php 
    if($mensaje != "") {
        echo $mensaje;
    }
    ?>
    <div class="row mt-5">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3>Consultar Pilotos</h3>
                </div>
                <div class="card-body">
                    <?php
                    if (count($pilotos) == 0) {
                        echo "<div class='alert alert-warning' role='alert'>
                                No hay registros de Pilotos
                                </div>";
                    } else {
                    ?>
                    <table class="table table-striped table-hover text-center align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Foto</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($pilotos as $p) {
                            
                            echo "<tr>";
                            echo "<td>" . $p->getId() . "</td>";
                            echo "<td><img src='imagenes/" . $p->getFotoPerfil() . "' alt='Foto de Perfil' width='50' height='50'></td>";
                            echo "<td>" . $p->getNombre() . "</td>";
                            echo "<td>" . $p->getApellido() . "</td>";
                            echo "<td>" . $p->getCorreo() . "</td>";

                            echo "<td id='estado" . $p->getId() . "'>";
                            echo $p->getEstado() == 1
                                ? "<i class='fa-solid fa-check text-success fs-4'></i>"
                                : "<i class='fa-solid fa-x text-danger fs-4'></i>";
                            echo "</td>";

                            echo "<td>";
                            echo "<div class='d-flex justify-content-center gap-3'>";
                            echo "<div id='habilitar" . $p->getId() . "' " . ($p->getEstado() == 1 ? "style='display:none'" : "") . ">
                                    <a href='#' title='Habilitar'>
                                        <i class='fa-regular fa-circle-check text-success fs-3'></i>
                                    </a>
                                    </div>";

                            echo "<div id='deshabilitar" . $p->getId() . "' " . ($p->getEstado() == 1 ? "" : "style='display:none'") . ">
                                    <a href='#' title='Deshabilitar'>
                                        <i class='fa-regular fa-circle-xmark text-danger fs-3'></i>
                                    </a>
                                    </div>";
                            echo "<a href='?pid=" . base64_encode('presentacion/Piloto/editarPiloto.php') . "&pilotoId=" . $p->getId() . "' title='Editar'>
                                    <i class='fa-solid fa-pen-to-square text-primary fs-4 me-2'></i>
                                </a>";
                            echo "<a href='?pid=" . base64_encode('presentacion/Piloto/consultarPiloto.php') . "&eliminar=" . $p->getId() . "' title='Eliminar' 
                                    onclick='return confirm(\"¿Estás seguro de que deseas eliminar este piloto?\")'>
                                    <i class='fa-solid fa-trash text-danger fs-4'></i>
                                </a>";

                            echo "</td>";

                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
<?php foreach ($pilotos as $p) { ?>
    $("#habilitar<?= $p->getId() ?> a").on("click", function(e) {
        e.preventDefault();
        var url = "cambiarEstadoPilotoAjax.php?idPiloto=<?= $p->getId() ?>&estado=1";
        $("#estado<?= $p->getId() ?>").load(url);
        $("#habilitar<?= $p->getId() ?>").hide();
        $("#deshabilitar<?= $p->getId() ?>").show();
    });

    $("#deshabilitar<?= $p->getId() ?> a").on("click", function(e) {
        e.preventDefault();
        var url = "cambiarEstadoPilotoAjax.php?idPiloto=<?= $p->getId() ?>&estado=0";
        $("#estado<?= $p->getId() ?>").load(url);
        $("#deshabilitar<?= $p->getId() ?>").hide();
        $("#habilitar<?= $p->getId() ?>").show();
    });
<?php } ?>
</script>
</body>