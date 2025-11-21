<?php
require_once ("logica/Avion.php");
$id =  $_SESSION["id"];
if ($_SESSION["rol"] != "admin") {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
}
$admin = new Admin($id);
$admin->consultarPorId();
if (isset($_POST["crearAvion"])) {
    $modelo = $_POST["modelo"];
    $capacidad = $_POST["capacidad"];
    $avion = new Avion(0, $modelo, $capacidad, 1);
    $avion->registrar();
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
                        <h3>Crear Avion</h3>
                    </div>
                    <div class="card-body">
                        <?php 
                        if(isset($_POST["crearAvion"])){
                            echo "<div class='alert alert-success' role='alert'>
                                    Avion almacenado exitosamente!
                                    </div>";
                        }
                        ?>
                        <form method="post" action="?pid=<?php echo base64_encode("presentacion/Avion/crearAvion.php")?>">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="modelo"
                                        placeholder="Modelo" required>
                                </div>
                                <div class="mb-3">
                                    <input type="number" class="form-control" name="capacidad"
                                        placeholder="Capacidad" required>
                                </div>
                                <button type="submit" name="crearAvion" class="btn btn-primary">Crear Avion</button>
                            </form>
                    </div>
                </div>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
</body>
