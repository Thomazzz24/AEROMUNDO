<?php
require_once("logica/Vuelo.php");
require_once("logica/Admin.php");

$id = $_SESSION["id"];
if ($_SESSION["rol"] != "admin") {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
}

$admin = new Admin($id);
$admin->consultarPorId();

$piloto = new Piloto();
$pilotosMasVuelos = $piloto->pilotosMasVuelos();
?>

<body>
    <?php include 'presentacion/administrador/menuAdministrador.php'; ?>
    
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3><i class="fa-solid fa-user-tie me-2"></i> Pilotos con Más Vuelos</h3>
                    </div>
                    <div class="card-body">
                        <div id="graficoPilotos" style="width: 100%; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4 mb-5">
            <div class="col text-center">
                <a href="?pid=<?= base64_encode("presentacion/administrador/sesionAdmin.php") ?>" 
                    class="btn btn-primary">
                    <i class="fa-solid fa-arrow-left me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Piloto', 'Cantidad de Vuelos'],
        <?php 
        foreach ($pilotosMasVuelos as $piloto) {
            echo "['" . $piloto[0] . "', " . $piloto[1] . "],\n";
        }
        ?>
    ]);
    
    var options = {
        title: 'Pilotos con Mayor Experiencia en Vuelos',
        chartArea: { width: '80%', height: '70%' },
        colors: ['#0d6efd'],
        legend: { position: 'none' },
        hAxis: {
            slantedText: true,
            slantedTextAngle: 45
        },
        vAxis: {
            title: 'Cantidad de Vuelos',
            minValue: 0
        }
    };
    
    var chart = new google.visualization.ColumnChart(document.getElementById('graficoPilotos'));
    chart.draw(data, options);
}

window.addEventListener('resize', drawChart);
</script>