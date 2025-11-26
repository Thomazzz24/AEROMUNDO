<?php
$id = $_SESSION["id"];
if (isset($_SESSION["id"]) && isset($_SESSION["rol"]) && $_SESSION["rol"] == "admin") {
    $admin = new Admin($_SESSION["id"]);
    $admin->consultarPorId();
}

include 'presentacion/administrador/menuAdministrador.php';

?>
<body>
    <div class="container mt-4">
    <h2 class="fw-bold mb-4">Panel de Control</h2>

    <div class="row g-4">

        <!-- Tarjeta 1 -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa-solid fa-user-tie fa-2x mb-2 text-danger"></i>
                    <h5 class="card-title">Pilotos</h5>
                    <a href="?pid=<?php echo base64_encode('presentacion/Piloto/consultarPiloto.php'); ?>" 
                       class="btn btn-danger btn-sm mt-2">Ver más</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta 2 -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa-solid fa-users fa-2x mb-2 text-danger"></i>
                    <h5 class="card-title">Clientes</h5>
                    <a href="?pid=<?php echo base64_encode('presentacion/Pasajero/consultarPasajero.php'); ?>" 
                       class="btn btn-danger btn-sm mt-2">Ver más</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta 3 -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa-solid fa-plane fa-2x mb-2 text-danger"></i>
                    <h5 class="card-title">Aviones</h5>
                    <a href="?pid=<?php echo base64_encode('presentacion/Avion/consultarAviones.php'); ?>" 
                       class="btn btn-danger btn-sm mt-2">Ver más</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta 4 -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa-solid fa-route fa-2x mb-2 text-danger"></i>
                    <h5 class="card-title">Rutas</h5>
                    <a href="?pid=<?php echo base64_encode('presentacion/Ruta/consultarRutas.php'); ?>" 
                       class="btn btn-danger btn-sm mt-2">Ver más</a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
include 'presentacion/Vuelos/consultarVuelos.php';
?>


</body>