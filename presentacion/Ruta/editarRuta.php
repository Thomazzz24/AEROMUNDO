<?php
require_once("logica/ruta.php");

$id = $_SESSION["id"];
if ($_SESSION["rol"] != "admin") {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
    exit();
}

$admin = new Admin($id);
$admin->consultarPorId();

$mensaje = "";

if (!isset($_GET["idRuta"])) {
    $mensaje = "<div class='alert alert-danger mt-3 text-center' role='alert'>
                    ID de ruta no proporcionado.
                </div>";
} else {
    $idRuta = $_GET["idRuta"];
    $ruta = new Ruta($idRuta);
    $ruta->consultarPorId();
}

if (isset($_POST["editarRuta"])) {
    $origen = $_POST["origen"];
    $destino = $_POST["destino"];
    $duracionMinutos = $_POST["duracion"];

    $horas = floor($duracionMinutos / 60);
    $minutos = $duracionMinutos % 60;
    $duracion = sprintf('%02d:%02d:00', $horas, $minutos);

    $ruta->setOrigen($origen);
    $ruta->setDestino($destino);
    $ruta->setDuracion($duracion);
    $ruta->editar();
    $ruta->consultarPorId();

    $mensaje = "<div class='alert alert-success mt-3 text-center' role='alert'>
                    Ruta editada exitosamente.
                </div>";
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
                    <h3>Editar Ruta</h3>
                </div>
                <div class="card-body">
                    <?php if($mensaje != "") echo $mensaje; ?>
                    <form method="post" action="?pid=<?php echo base64_encode("presentacion/Ruta/editarRuta.php") . "&idRuta=" . $ruta->getId(); ?>">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="origen"
                                placeholder="Origen" value="<?php echo $ruta->getOrigen(); ?>" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="destino"
                                placeholder="Destino" value="<?php echo $ruta->getDestino(); ?>" required>
                        </div>
                        <div class="mb-3">
                            <?php
                            list($horas, $minutos, $segundos) = explode(":", $ruta->getDuracion());
                            $duracionMinutos = $horas * 60 + $minutos;
                            ?>
                            <input type="number" class="form-control" name="duracion"
                                placeholder="Duración Estimada (minutos)" value="<?php echo $duracionMinutos; ?>" required>
                        </div>
                        <button type="submit" name="editarRuta" class="btn btn-primary">Editar Ruta</button>
                        <a href="?pid=<?php echo base64_encode("presentacion/Ruta/consultarRutas.php"); ?>" class="btn btn-secondary mt-2">Volver</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-4"></div>
    </div>
</div>
</body>
