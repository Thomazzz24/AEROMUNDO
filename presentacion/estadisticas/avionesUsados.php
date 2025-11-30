<?php
require_once("logica/Vuelo.php");
require_once("logica/Admin.php");
require_once("logica/Avion.php");

$id = $_SESSION["id"];
if ($_SESSION["rol"] != "admin") {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
}

$admin = new Admin($id);
$admin->consultarPorId();

$avion = new Avion();
$avionesMasUsados = $avion->avionesMasUsados();
?>

<?php include 'presentacion/administrador/menuAdministrador.php'; ?>

<div class="container">
    <div class="row mt-5">
        <div class="col">
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h3><i class="fa-solid fa-plane me-2"></i> Aviones Más Usados</h3>
                </div>
                <div class="card-body">
                    <div id="graficoAviones" style="width: 100%; height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 mb-5">
        <div class="col text-center">
            <a href="?pid=<?= base64_encode("presentacion/administrador/sesionAdmin.php") ?>" 
                class="btn btn-danger">
                <i class="fa-solid fa-arrow-left me-2"></i> Volver
            </a>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart', 'bar']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Avión', 'Cantidad de Vuelos'],
        <?php 
        foreach ($avionesMasUsados as $avion) {
            echo "['" . $avion[0] . "', " . $avion[1] . "],\n";
        }
        ?>
    ]);
    
    var options = {
        title: 'Top 10 Aviones con Mayor Cantidad de Vuelos',
        chartArea: { width: '70%', height: '75%' },
        hAxis: {
            title: 'Cantidad de Vuelos',
            minValue: 0
        },
        vAxis: {
            title: 'Modelo de Avión'
        },
        colors: ['#dc3545'],
        legend: { position: 'none' }
    };
    
    var chart = new google.visualization.BarChart(document.getElementById('graficoAviones'));
    chart.draw(data, options);
}

window.addEventListener('resize', drawChart);
</script>