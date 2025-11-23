<?php
$id = $_SESSION["id"];
if ($_SESSION["rol"] != "admin") {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
}
$admin = new Admin($id);
$admin->consultarPorId();

$mensaje = "";

if (isset($_POST["crearVuelo"])) {

    $fechaSalida = $_POST["fecha"] . " " . $_POST["hora"] . ":00";
    $rutaId = $_POST["ruta"];
    $avionId = $_POST["avion"];
    $pilotoId = $_POST["piloto_principal"];
    $copilotoId = $_POST["copiloto"];
    $fechallegada = $_POST["fecha_llegada"];

    if (empty($rutaId) || empty($avionId) || empty($pilotoId) || empty($copilotoId) || empty($fechallegada)) {
        $mensaje = "<div class='alert alert-danger'>Error: Todos los campos son obligatorios.</div>";
    } else {
        $rutaObj = new Ruta($rutaId);
        if (!$rutaObj->consultarPorId()) {
            $mensaje = "<div class='alert alert-danger'>Error: La ruta seleccionada no es válida.</div>";
        } else {
            try {
                $vuelo = new Vuelo();
                $vuelo->setId_ruta($rutaId);
                $vuelo->setId_avion($avionId);
                $vuelo->setId_piloto_principal($pilotoId);
                $vuelo->setId_copiloto($copilotoId);
                $vuelo->setFecha_salida($fechaSalida);
                $vuelo->setFecha_llegada($fechallegada);
                $vuelo->setEstado(1);
                
                $vuelo->registrar();
                $mensaje = "<div class='alert alert-success'>Vuelo almacenado exitosamente!</div>";
            } catch (Exception $e) {
                $mensaje = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
            }
        }
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
                        <h3>Crear Vuelo</h3>
                    </div>
                    <div class="card-body">

                        <?php 
                        if(isset($_POST["crearVuelo"])){
                            echo $mensaje;
                        }
                        ?>

                        <form method="post" action="?pid=<?php echo base64_encode("presentacion/Vuelos/crearVuelos.php")?>" id="formCrearVuelo">

                            <div class="mb-3">
                                <label for="ruta" class="form-label">Ruta</label>
                                <select class="form-select" name="ruta" id="ruta" required>
                                    <option value="">Seleccione una ruta</option>
                                    <?php
                                    $ruta = new Ruta();
                                    $rutas = $ruta->consultarTodos();
                                    foreach ($rutas as $r) {
                                        echo "<option value='" . $r->getId() . "'>" . $r->getOrigen() . " - " . $r->getDestino() . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <input type="hidden" name="duracion" id="duracion">

                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha de salida</label>
                                <input type="date" class="form-control" name="fecha" id="fecha" required>
                            </div>

                            <div class="mb-3">
                                <label for="hora" class="form-label">Hora de salida</label>
                                <input type="time" class="form-control" name="hora" id="hora" required>
                            </div>

                            <input type="hidden" name="fecha_llegada" id="fecha_llegada" required>

                            <div class="mb-3">
                                <label for="avion" class="form-label">Avión</label>
                                <select class="form-select" name="avion" id="avion" required>
                                    <option value="">Primero seleccione fecha y hora</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="piloto_principal" class="form-label">Piloto Principal</label>
                                <select class="form-select" name="piloto_principal" id="piloto_principal" required>
                                    <option value="">Primero seleccione fecha y hora</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="copiloto" class="form-label">Copiloto</label>
                                <select class="form-select" name="copiloto" id="copiloto" required>
                                    <option value="">Primero seleccione un piloto principal</option>
                                </select>
                            </div>

                            <button type="submit" name="crearVuelo" class="btn btn-primary" id="btnSubmit">Crear Vuelo</button>
                        </form>

                    </div>
                </div>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
    <script src="js/crearVuelo.js"></script>

</body>