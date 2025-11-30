<?php
require_once("logica/Vuelo.php");
require_once("logica/Admin.php");
require_once("logica/Ruta.php");

$id = $_SESSION["id"];
if ($_SESSION["rol"] != "admin") {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
}

$admin = new Admin($id);
$admin->consultarPorId();

$Ruta = new ruta();
$rutasMasUsadas = $Ruta->rutasMasUsadas();
?>

<body>
    <?php include 'presentacion/administrador/menuAdministrador.php'; ?>
    
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h3><i class="fa-solid fa-route me-2"></i> Rutas Más Utilizadas</h3>
                    </div>
                    <div class="card-body">
                        <div id="graficoRutas" style="width: 100%; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4 mb-5">
            <div class="col text-center">
                <a href="?pid=<?= base64_encode("presentacion/administrador/sesionAdmin.php") ?>" 
                    class="btn btn-success">
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
        ['Ruta', 'Cantidad de Vuelos'],
        <?php 
        foreach ($rutasMasUsadas as $ruta) {
            echo "['" . $ruta[0] . "', " . $ruta[1] . "],\n";
        }
        ?>
    ]);
    
    var options = {
        title: 'Top 10 Rutas Más Frecuentes',
        pieHole: 0.4,
        chartArea: { width: '90%', height: '75%' },
        legend: { position: 'bottom' }
    };
    
    var chart = new google.visualization.PieChart(document.getElementById('graficoRutas'));
    chart.draw(data, options);
}

window.addEventListener('resize', drawChart);
</script>