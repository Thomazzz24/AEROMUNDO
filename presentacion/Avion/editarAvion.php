<?php
require_once ("logica/Avion.php");

$id =  $_SESSION["id"];
if ($_SESSION["rol"] != "admin") {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
}
$admin = new Admin($id);
$admin->consultarPorId();

$mensaje = "";

if (isset($_GET["idAvion"])) {
    $idAvion = $_GET["idAvion"];
    $avion = new Avion($idAvion);
    $avion->consultarPorId();
}else{
    $mensaje = "<div class='alert alert-danger mt-3 text-center' role='alert'>
                    ID de avión no proporcionado.
                </div>";
}


if (isset($_POST["editarAvion"])) {
    $modelo = $_POST["modelo"];
    $capacidad = $_POST["capacidad"];

    $avion->setModelo($modelo);
    $avion->setCapacidad($capacidad);
    $avion->editar();
    $avion->consultarPorId();
    $mensaje = "<div class='alert alert-success mt-3 text-center' role='alert'>
                    Avión editado exitosamente.
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
                        <h3>Editar Avión</h3>
                    </div>
                    <div class="card-body">
                        <?php 
                        if($mensaje != "") {
                            echo $mensaje;
                        }
                        ?>
                        <form method="post" action="?pid=<?php echo base64_encode("presentacion/Avion/editarAvion.php") . "&idAvion=" . $avion->getId() ?>">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="modelo"
                                        placeholder="Modelo" value="<?php echo $avion->getModelo() ?>" required>
                                </div>
                                <div class="mb-3">
                                    <input type="number" class="form-control" name="capacidad"
                                        placeholder="Capacidad" value="<?php echo $avion->getCapacidad() ?>" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary" name="editar">Guardar Cambios</button>
                                    <a href="?pid=<?php echo base64_encode('presentacion/Avion/consultarAviones.php'); ?>" 
                                    class="btn btn-secondary mt-2">Volver</a>
                                </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
</body>