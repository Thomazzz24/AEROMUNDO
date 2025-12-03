<nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow-sm py-3">
    <div class="container-fluid">

        <!-- Logo -->
        <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
            <img src="img/logo.jpg" alt="Logo" width="45" height="45" 
                 class="me-2 rounded-circle border border-light shadow-sm">
            <span class="fs-4">AEROMUNDO</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- INICIO -->
                <li class="nav-item">
                    <a class="nav-link active"
                        href="?pid=<?php echo base64_encode('presentacion/inicio.php'); ?>">
                        <i class="fa-solid fa-house me-1"></i> Inicio
                    </a>
                </li>

        
                <!-- PILOTOS -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-user-tie me-1"></i> Pilotos
                    </a>
                    <ul class="dropdown-menu shadow-sm">
                        <li><a class="dropdown-item"
                                href="?pid=<?php echo base64_encode('presentacion/Piloto/crearPiloto.php'); ?>">
                                Registrar Pilotos</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="?pid=<?php echo base64_encode('presentacion/Piloto/consultarPiloto.php'); ?>">
                                Consultar Pilotos</a>
                        </li>
                    </ul>
                </li>

                <!-- CLIENTES -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-users me-1"></i> Clientes
                    </a>
                    <ul class="dropdown-menu shadow-sm">
                        <li><a class="dropdown-item"
                                href="?pid=<?php echo base64_encode('presentacion/Pasajero/consultarPasajero.php'); ?>">
                                Consultar Clientes/Pasajeros</a>
                        </li>
                    </ul>
                </li>

                <!-- AVIONES -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-plane me-1"></i> Aviones
                    </a>
                    <ul class="dropdown-menu shadow-sm">
                        <li><a class="dropdown-item"
                                href="?pid=<?php echo base64_encode('presentacion/Avion/crearAvion.php'); ?>">
                                Registrar Aviones</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="?pid=<?php echo base64_encode('presentacion/Avion/consultarAviones.php'); ?>">
                                Consultar Aviones</a>
                        </li>
                    </ul>
                </li>

                <!-- RUTAS -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-route me-1"></i> Rutas
                    </a>
                    <ul class="dropdown-menu shadow-sm">
                        <li><a class="dropdown-item"
                                href="?pid=<?php echo base64_encode('presentacion/Ruta/crearRuta.php'); ?>">
                                Crear Ruta</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="?pid=<?php echo base64_encode('presentacion/Ruta/consultarRutas.php'); ?>">
                                Consultar Rutas</a>
                        </li>
                    </ul>
                </li>

                <!-- VUELOS -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-plane-departure me-1"></i> Vuelos
                    </a>
                    <ul class="dropdown-menu shadow-sm">
                        <li><a class="dropdown-item"
                                href="?pid=<?php echo base64_encode('presentacion/Vuelos/crearVuelos.php'); ?>">
                                Registrar Vuelos</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="?pid=<?php echo base64_encode('presentacion/Vuelos/consultarVuelos.php'); ?>">
                                Consultar Vuelos</a>
                        </li>
                    </ul>
                </li>

                <!-- ESTADISTICAS -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-chart-line me-1"></i> Estadísticas
                    </a>
                    <ul class="dropdown-menu shadow-sm">
                        <li>
                            <a class="dropdown-item"
                            href="?pid=<?php echo base64_encode('presentacion/estadisticas/avionesUsados.php'); ?>">
                            <i class="fa-solid fa-plane me-2"></i> Aviones Más Usados
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                            href="?pid=<?php echo base64_encode('presentacion/estadisticas/pilotosVuelos.php'); ?>">
                            <i class="fa-solid fa-user-tie me-2"></i> Pilotos con Más Vuelos
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item"
                            href="?pid=<?php echo base64_encode('presentacion/estadisticas/rutasUsadas.php'); ?>">
                            <i class="fa-solid fa-route me-2"></i> Rutas Más Utilizadas
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

            <!-- USUARIO -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-circle-user fa-lg me-2"></i>
                        <span class="fw-semibold">
                            <?php echo $admin->getNombre() . " " . $admin->getApellido(); ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <a class="dropdown-item" href="editarPerfil.php">
                                <i class="fa-solid fa-user-pen me-2"></i> Editar Perfil
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item text-danger" href="?salir=true">
                                <i class="fa-solid fa-right-from-bracket me-2"></i> Salir
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>
