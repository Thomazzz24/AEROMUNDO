<?php
session_start();
require_once("logica/Vuelo.php");

$v = new Vuelo();
$listaVuelos = $v->consultarProximosVuelos();
?>

<body class="bg-light">

	<!-- NAVBAR -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-danger fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="#">
                <img src="img/logo.jpg" alt="Logo" width="40" height="40" class="me-2 rounded-circle border border-light">
                AeroMundo Viajes
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active text-white fw-semibold" href="?pid=<?php echo base64_encode('presentacion/inicio.php'); ?>">Inicio</a>
                    </li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Vuelos</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Reservar</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Check-in</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Contactos</a></li>
                </ul>

                <?php if (!isset($_SESSION["id"])) { ?>
                    <a href="?pid=<?php echo base64_encode('autenticacion/autenticar.php'); ?>" 
                        class="btn btn-outline-light ms-3">
                        <i class="fa-solid fa-user me-1"></i> Iniciar Sesión
                    </a>
                <?php } else { ?>
                    <span class="text-white ms-3 fw-semibold">
                        <i class="fa-solid fa-user-circle me-1"></i>
                        <?php echo ucfirst($_SESSION["rol"]); ?>
                    </span>
                <?php } ?>
            </div>
        </div>
    </nav>

    <!-- CARRUSEL -->
    <div id="carousel" class="carousel slide mt-5 pt-4" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="1"></button>
        </div>

        <div class="carousel-inner rounded shadow">
            <div class="carousel-item active">
                <img src="img/carrusel1.jpg" class="d-block w-100" style="height: 420px; object-fit: cover;">
                <div class="carousel-caption bg-danger bg-opacity-75 rounded p-3 shadow">
                    <h3 class="fw-bold">Descubre el mundo con nosotros</h3>
                    <p>Encuentra vuelos económicos y destinos soñados.</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="img/carrusel2.jpg" class="d-block w-100" style="height: 420px; object-fit: cover;">
                <div class="carousel-caption bg-danger bg-opacity-75 rounded p-3 shadow">
                    <h3 class="fw-bold">Explora sin límites</h3>
                    <p>Ofertas únicas a los mejores destinos turísticos.</p>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- BUSCADOR -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="text-danger fw-bold mb-3">Buscar vuelos</h4>

            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Origen</label>
                    <select id="origen" class="form-select">
                        <option value="">Todos</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Destino</label>
                    <select id="destino" class="form-select">
                        <option value="">Todos</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Fecha de vuelo</label>
                    <input type="date" id="fecha" class="form-control">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button id="btnBuscar" class="btn btn-danger w-100">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> Buscar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- VUELOS DISPONIBLES -->
    <div class="container my-5">
        <h2 class="text-center mb-4 text-danger fw-bold">Vuelos Disponibles</h2>

        <div class="row row-cols-1 row-cols-md-3 g-4" id="contenedorVuelos">

            <?php foreach ($listaVuelos as $vuelo): ?>

            <div class="col">
                <div class="card h-100 shadow-sm border-0">

                    <?php
                    $img = "img/default.jpg";
                    $dest = $vuelo->getDestino();
                    $imagenes = [
                        "Cartagena" => "img/cartagena2.jpg",
                        "Madrid" => "img/madrid.webp",
                        "Medellín" => "img/medellin.jpg",
                        "Cali" => "img/cali.jpg",
                        "Santa Marta" => "img/santaMarta.jpg",
                        "Pereira" => "img/pereira.jpg",
                        "Bogota" => "img/bogota.jpg"
                    ];
                    if (isset($imagenes[$dest])) $img = $imagenes[$dest];
                    ?>

                    <img src="<?= $img ?>" class="card-img-top" style="height:200px; object-fit:cover;">

                    <div class="card-body">
                        <h5 class="card-title fw-bold text-danger">
                            <?= $vuelo->getOrigen() ?> → <?= $vuelo->getDestino() ?>
                        </h5>

                        <p class="card-text">
                            <strong>Fecha salida:</strong> <?= date("d/m/Y H:i", strtotime($vuelo->getFecha_salida())) ?><br>
                            <strong>Fecha llegada:</strong> <?= date("d/m/Y H:i", strtotime($vuelo->getFecha_llegada())) ?><br>
                            <strong>Avión:</strong> <?= $vuelo->getModelo() ?><br>
                            <strong>Piloto:</strong> <?= $vuelo->getPiloto_principal() ?><br>
                            <strong>Copiloto:</strong> <?= $vuelo->getCopiloto() ?>
                        </p>

                        <?php $idVuelo = $vuelo->getId_vuelo(); ?>

                        <!-- SI NO ES PASAJERO O NO ESTÁ LOGUEADO -->
                        <?php if (!isset($_SESSION["id"]) || $_SESSION["rol"] != "pasajero") { ?>

                            <a href="?pid=<?= base64_encode('autenticacion/autenticar.php') ?>&redir=<?= $idVuelo ?>"
                               class="btn btn-danger w-100">
                               <i class="fa-solid fa-plane-departure me-1"></i> Reservar vuelo
                            </a>

                        <?php } else { ?>

                            <!-- SI ESTÁ LOGUEADO COMO PASAJERO -->
                            <a href="?pid=<?= base64_encode('presentacion/Pasajero/comprarTiquete.php') ?>&idVuelo=<?= $idVuelo ?>"
                               class="btn btn-danger w-100">
                               <i class="fa-solid fa-plane-departure me-1"></i> Reservar vuelo
                            </a>

                        <?php } ?>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>

        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-danger text-white text-center py-4 mt-5 shadow-sm">
        <div class="container">
            <p class="mb-1 fw-semibold">© 2025 AeroMundo Viajes - Todos los derechos reservados</p>
            <p class="fw-light">
                <i class="fa-solid fa-phone me-1"></i> +57 310 456 7890 |
                <i class="fa-solid fa-envelope ms-2 me-1"></i> contacto@aeromundo.com
            </p>
        </div>
    </footer>

<script>
/* ============================
   BUSCADOR DINÁMICO (AJAX)
   ============================ */
$(document).ready(function () {

    function cargarOrigenes() {
        $.ajax({
            url: "Ajax/obtenerOrigenes.php",
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#origen").html('<option value="">Todos los orígenes</option>');
                data.forEach(function (o) {
                    $("#origen").append(`<option value="${o}">${o}</option>`);
                });
            }
        });
    }

    function cargarDestinos() {
        $.ajax({
            url: "Ajax/obtenerDestinos.php",
            method: "GET",
            data: { origen: $("#origen").val() },
            dataType: "json",
            success: function (data) {
                $("#destino").html('<option value="">Todos los destinos</option>');
                data.forEach(function (d) {
                    $("#destino").append(`<option value="${d}">${d}</option>`);
                });
            }
        });
    }

    function buscarVuelos() {
        $.ajax({
            url: "Ajax/buscarVuelos.php",
            method: "GET",
            data: { 
                origen: $("#origen").val(),
                destino: $("#destino").val(),
                fecha: $("#fecha").val()
            },
            success: function (html) {
                $("#contenedorVuelos").html(html);
            }
        });
    }

    $("#origen").change(function () {
        cargarDestinos();
        buscarVuelos();
    });

    $("#destino").change(buscarVuelos);
    $("#fecha").change(buscarVuelos);
    $("#btnBuscar").click(buscarVuelos);

    cargarOrigenes();
    cargarDestinos();
});
</script>

</body>
