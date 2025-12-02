<?php
require_once("logica/Vuelo.php");
require_once("logica/Pasajero.php");
if (!isset($_SESSION["id"]) || $_SESSION["rol"] != "pasajero") {
    header('Location: ?pid=' . base64_encode("autenticacion/noAutorizado.php"));
    exit();
}

$v = new Vuelo();
$listaVuelos = $v->consultarProximosVuelos();
?>

<?php
include "presentacion/pasajero/menuPasajero.php";
?>

<body class="bg-light">
    <div class="container my-5">

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

                    <!-- Imagen dinámica según destino (opcional) -->
                    <?php
                    $img = "img/default.jpg";
                    if ($vuelo->getDestino() == "Cartagena") $img = "img/cartagena2.jpg";
                    if ($vuelo->getDestino() == "Madrid") $img = "img/madrid.webp";
                    if ($vuelo->getDestino() == "Medellín") $img = "img/medellin.jpg";
                    if ($vuelo->getDestino() == "Cali") $img = "img/cali.jpg";
                    if ($vuelo->getDestino() == "Santa Marta") $img = "img/santaMarta.jpg";
                    if ($vuelo->getDestino() == "Pereira") $img = "img/pereira.jpg";
                    if ($vuelo->getDestino() == "Bogota") $img = "img/bogota.jpg";
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

                        <?php if (!isset($_SESSION["id"]) || $_SESSION["rol"] != "pasajero") { ?>
                            <a href="?pid=<?= base64_encode('autenticacion/autenticar.php') ?>&redir=<?= $idVuelo ?>"
                               class="btn btn-danger w-100">
                               <i class="fa-solid fa-plane-departure me-1"></i> Reservar vuelo
                            </a>
                        <?php } else { ?>
                            <a href="?pid=<?= base64_encode('presentacion/pasajero/comprarTiquete.php') ?>&idVuelo=<?= $idVuelo ?>"
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
    </div>
    <script>
        $(document).ready(function () {

    // Cargar orígenes al inicio
    function cargarOrigenes() {
        console.log("🔄 Cargando orígenes...");
        
        $.ajax({
            url: "Ajax/obtenerOrigenes.php",
            method: "GET",
            dataType: "json",
            success: function (data) {
                console.log("✅ Orígenes recibidos:", data);
                
                if (data.error) {
                    console.error("❌ Error del servidor:", data.mensaje);
                    alert("Error al cargar orígenes: " + data.mensaje);
                    return;
                }
                
                $("#origen").html('<option value="">Todos los orígenes</option>');
                data.forEach(function (origen) {
                    $("#origen").append(`<option value="${origen}">${origen}</option>`);
                });
                console.log("✅ Select de origen llenado");
            },
            error: function (xhr, status, error) {
                console.error("❌ Error AJAX al cargar orígenes:", error);
                console.error("Respuesta del servidor:", xhr.responseText);
                alert("Error de conexión al cargar orígenes. Revisa la consola.");
            }
        });
    }

    // Cargar destinos (puede filtrarse por origen)
    function cargarDestinos() {
        let origenSeleccionado = $("#origen").val();
        console.log("🔄 Cargando destinos para origen:", origenSeleccionado || "todos");
        
        $.ajax({
            url: "Ajax/obtenerDestinos.php",
            method: "GET",
            data: { origen: origenSeleccionado },
            dataType: "json",
            success: function (data) {
                console.log("✅ Destinos recibidos:", data);
                
                if (data.error) {
                    console.error("❌ Error del servidor:", data.mensaje);
                    alert("Error al cargar destinos: " + data.mensaje);
                    return;
                }
                
                let destinoActual = $("#destino").val();
                $("#destino").html('<option value="">Todos los destinos</option>');
                
                data.forEach(function (destino) {
                    let selected = (destino == destinoActual) ? 'selected' : '';
                    $("#destino").append(`<option value="${destino}" ${selected}>${destino}</option>`);
                });
                console.log("✅ Select de destino llenado");
            },
            error: function (xhr, status, error) {
                console.error("❌ Error AJAX al cargar destinos:", error);
                console.error("Respuesta del servidor:", xhr.responseText);
                alert("Error de conexión al cargar destinos. Revisa la consola.");
            }
        });
    }

    // Buscar vuelos según los filtros
    function buscarVuelos() {
        let origen = $("#origen").val();
        let destino = $("#destino").val();
        let fecha = $("#fecha").val();

        console.log("🔍 Buscando vuelos con:", { origen, destino, fecha });

        // Mostrar indicador de carga
        $("#contenedorVuelos").html(`
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-danger" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p class="mt-3 text-muted">Buscando vuelos...</p>
            </div>
        `);

        // Realizar búsqueda
        $.ajax({
            url: "Ajax/buscarVuelos.php",
            method: "GET",
            data: { origen, destino, fecha },
            success: function (html) {
                console.log("✅ Vuelos cargados");
                $("#contenedorVuelos").html(html);
            },
            error: function (xhr, status, error) {
                console.error("❌ Error al buscar vuelos:", error);
                $("#contenedorVuelos").html(`
                    <div class="col-12">
                        <div class="alert alert-danger">
                            <strong>Error:</strong> No se pudieron cargar los vuelos. 
                            Revisa la consola para más detalles.
                        </div>
                    </div>
                `);
            }
        });
    }

    // Eventos
    $("#origen").change(function() {
        console.log("📍 Origen cambiado a:", $(this).val());
        cargarDestinos(); // Recargar destinos según origen
        buscarVuelos();   // Buscar vuelos
    });

    $("#destino").change(function() {
        console.log("📍 Destino cambiado a:", $(this).val());
        buscarVuelos();
    });

    $("#fecha").change(function() {
        console.log("📅 Fecha cambiada a:", $(this).val());
        buscarVuelos();
    });
    
    $("#btnBuscar").click(function() {
        console.log("🔘 Botón buscar presionado");
        buscarVuelos();
    });

    // Inicializar
    console.log("🚀 Inicializando buscador de vuelos...");
    cargarOrigenes();
    cargarDestinos();
});
    </script>


</body>
