<?php
require_once ("logica/Ruta.php");

$id =  $_SESSION["id"];
if ($_SESSION["rol"] != "admin") {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
}
$admin = new Admin($id);
$admin->consultarPorId();

$mensaje = "";

if (isset($_POST["crearRuta"])) {
    $origen = trim($_POST["origen"]);
    $destino = trim($_POST["destino"]);
    $duracionMinutos = intval($_POST["duracion"]);

    if ($duracionMinutos <= 0) {
        $mensaje = "<div class='alert alert-danger'>La duración debe ser mayor a 0 minutos.</div>";
    } else {
        
        $horas = floor($duracionMinutos / 60);
        $minutos = $duracionMinutos % 60;
        $duracion = sprintf("%02d:%02d:00", $horas, $minutos);
        $ruta = new Ruta(0, $origen, $destino, $duracion);
        $ruta->registrar();
        $mensaje =  "<div class='alert alert-success'>Ruta almacenada exitosamente!</div>";
    }
}

?>
<body>
<?php include 'presentacion/administrador/menuAdministrador.php'; ?>
    <div class="container">
        <div class="row mt-5">
            <div class="col-4"></div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Crear Ruta</h3>
                    </div>
                    <div class="card-body">
                        <?php 
                        if(isset($_POST["crearRuta"])){
                            echo $mensaje;
                        }
                        ?>
                        <form method="post" action="?pid=<?php echo base64_encode("presentacion/Ruta/crearRuta.php")?>">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="origen"
                                        placeholder="Origen" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="destino"
                                        placeholder="Destino" required>
                                </div>
                                <div class="mb-3">
                                    <input type="number" class="form-control" name="duracion"
                                        placeholder="Duración Estimada (minutos)" required>
                                </div>
                                <button type="submit" name="crearRuta" class="btn btn-primary">Crear Ruta</button>
                            </form>
                    </div>
                </div>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
</body>
