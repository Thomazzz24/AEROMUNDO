<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="card-title">
                    <i class="fa-solid fa-house-user me-2"></i>
                    Bienvenido, <?php echo $piloto->getNombre(). " " . $piloto->getApellido(); ?>
                </h2>
                <p class="text-muted">Panel de control para pilotos</p>
                <hr>
                
                <div class="row g-4 mt-3">
                    <div class="col-md-4">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-plane fa-3x text-primary mb-3"></i>
                                <h5 class="card-title">Mis Vuelos</h5>
                                <p class="card-text">Consulta tus vuelos programados</p>
                                <a href="?pid=<?php echo base64_encode('presentacion/Piloto/misVuelos.php'); ?>" 
                                    class="btn btn-primary">
                                    Ver Vuelos
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-info">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-clock-rotate-left fa-3x text-info mb-3"></i>
                                <h5 class="card-title">Historial</h5>
                                <p class="card-text">Revisa tus vuelos anteriores</p>
                                <a href="?pid=<?php echo base64_encode('presentacion/Piloto/historialVuelos.php'); ?>" 
                                    class="btn btn-info">
                                    Ver Historial
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>