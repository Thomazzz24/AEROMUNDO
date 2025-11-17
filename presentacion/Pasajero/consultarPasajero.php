<?php
require_once ("logica/Pasajero.php");
$pasajero =  new Pasajero();
$pasajeros = $pasajero->consultarTodos();
$id = $_SESSION["id"];
if ($_SESSION["rol"] != "admin") {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
}
$admin = new Admin($id);
$admin->consultarPorId();
?>
<body>
<?php include 'presentacion/menuAdministrador.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<div class="container">
    <div class="row mt-5">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3>Consultar Clientes</h3>
                </div>
                <div class="card-body">
                    <?php
                    if (count($pasajeros) == 0) {
                        echo "<div class='alert alert-warning' role='alert'>
                                No hay registros de clientes
                              </div>";
                    } else {
                    ?>
                    <table class="table table-striped table-hover text-center align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($pasajeros as $p) {
                            echo "<tr>";
                            echo "<td>" . $p->getId() . "</td>";
                            echo "<td>" . $p->getNombre() . "</td>";
                            echo "<td>" . $p->getApellido() . "</td>";
                            echo "<td>" . $p->getCorreo() . "</td>";

                            echo "<td id='estado" . $p->getId() . "'>";
                            echo $p->getEstado() == 1
                                ? "<i class='fa-solid fa-check text-success fs-4'></i>"
                                : "<i class='fa-solid fa-x text-danger fs-4'></i>";
                            echo "</td>";

                            echo "<td>";
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
<?php foreach ($pasajeros as $p) { ?>
    $("#habilitar<?= $p->getId() ?> a").on("click", function(e) {
        e.preventDefault();
        var url = "cambiarEstadoClienteAjax.php?idCliente=<?= $p->getId() ?>&estado=1";
        $("#estado<?= $p->getId() ?>").load(url);
        $("#habilitar<?= $p->getId() ?>").hide();
        $("#deshabilitar<?= $p->getId() ?>").show();
    });

    $("#deshabilitar<?= $p->getId() ?> a").on("click", function(e) {
        e.preventDefault();
        var url = "cambiarEstadoClienteAjax.php?idCliente=<?= $p->getId() ?>&estado=0";
        $("#estado<?= $p->getId() ?>").load(url);
        $("#deshabilitar<?= $p->getId() ?>").hide();
        $("#habilitar<?= $p->getId() ?>").show();
    });
<?php } ?>
</script>
</body>