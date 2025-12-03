<?php
require_once("logica/Pasajero.php");

if (isset($_SESSION["id"]) && $_SESSION["rol"] == "pasajero") {
    $pasajero = new Pasajero($_SESSION["id"]);
    $pasajero->consultarPorId();
}

?>

<?php
include_once("presentacion/Pasajero/menuPasajero.php");
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow-sm py-3">
    <div class="container-fluid">

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

                <li class="nav-item">
                    <a class="nav-link active"
                        href="?pid=<?php echo base64_encode('presentacion/inicio.php'); ?>">
                        <i class="fa-solid fa-house me-1"></i> Inicio
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                        href="?pid=<?php echo base64_encode('presentacion/Pasajero/comprarVuelo.php'); ?>">
                        <i class="fa-solid fa-plane-departure me-1"></i> Buscar Vuelos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                        href="?pid=<?php echo base64_encode('presentacion/Pasajero/misTiquetes.php'); ?>">
                        <i class="fa-solid fa-ticket me-1"></i> Mis Tiquetes
                    </a>
                </li>

            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-circle-user fa-lg me-2"></i>
                        <span class="fw-semibold">
                            <?php echo $pasajero->getNombre() . " " . $pasajero->getApellido(); ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <a class="dropdown-item" href="?pid=<?php echo base64_encode('presentacion/Pasajero/editarPerfil.php'); ?>">
                                <i class="fa-solid fa-user-pen me-2"></i> Editar Perfil
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item text-danger" href="?salir=true">
                                <i class="fa-solid fa-right-from-bracket me-2"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>
