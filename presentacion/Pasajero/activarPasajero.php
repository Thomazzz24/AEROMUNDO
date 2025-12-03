<?php 
require_once ("logica/Persona.php");
require_once ("logica/Pasajero.php");
$correo = base64_decode($_GET["correo"]);
$pasajero = new Pasajero();
$pasajero -> activar($correo);
?>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
        <div class="card shadow p-4 border-0 rounded-4 text-center">
            <div class="text-success display-4 mb-3">✔</div>
            <h4 class="fw-bold">Cliente activado</h4>
            <p class="text-muted">Proceso completado exitosamente.</p>
        </div>
    </div>
</body>

