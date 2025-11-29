<?php

require_once("logica/Persona.php");
require_once("logica/Admin.php");
require_once("logica/Piloto.php");
require_once("logica/Pasajero.php");
$error = 0;

if (isset($_POST["autenticar"])) {
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];

    $admin = new Admin(0, "", "", $correo, $clave);
    if ($admin->autenticar()) {
        $_SESSION["id"] = $admin->getId();
        $_SESSION["rol"] = "admin";
        header("Location: ?pid=" . base64_encode("presentacion/administrador/sesionAdmin.php"));
        exit();
    }else{
        $pasajero = new Pasajero(0, "", "", $correo, $clave);
            if ($pasajero->autenticar()) {
                if($pasajero-> getEstado()){
                    $_SESSION["id"] = $pasajero->getId();
                    $_SESSION["rol"] = "pasajero";
                    header("Location: ?pid=" . base64_encode("presentacion/pasajero/menuPasajero.php"));
                    exit();
                }else{
                    $error = 2;         
                }
            }else{
                $error = 1;
            }    
    }

    $piloto = new Piloto(0, "", "", $correo, $clave);
    if ($piloto->autenticar()) {
        $_SESSION["id"] = $piloto->getId();
        $_SESSION["rol"] = "piloto";
        header("Location: ?pid=" . base64_encode("presentacion/piloto/sesionPiloto.php"));
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aerolinea - Autenticación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-lg border-0 rounded-4">
                
                <!-- Encabezado -->
                <div class="card-header text-center bg-danger text-white rounded-top-4 py-4">
                    <i class="fa-solid fa-circle-user fa-3x mb-2"></i>
                    <h4 class="fw-bold m-0">Iniciar Sesión</h4>
                </div>

                <div class="card-body p-4">

                    <?php if ($error) { ?>
                        <div class="alert alert-danger text-center fw-semibold">
                            Correo o clave incorrectos.
                        </div>
                    <?php } ?>

                    <form method="post" action="?pid=<?php echo base64_encode('autenticacion/autenticar.php'); ?>">

                        <!-- Correo -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-danger">Correo electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text bg-danger text-white">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" name="correo" placeholder="correo@ejemplo.com" required>
                            </div>
                        </div>

                        <!-- Clave -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-danger">Clave</label>
                            <div class="input-group">
                                <span class="input-group-text bg-danger text-white">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" name="clave" placeholder="*******" required>
                            </div>
                        </div>

                        <!-- Botón -->
                        <div class="d-grid mb-3">
                            <button type="submit" name="autenticar" class="btn btn-danger fw-semibold">
                                <i class="fa-solid fa-right-to-bracket me-1"></i> Ingresar
                            </button>
                        </div>

                        <!-- Registro -->
                        <div class="text-center mt-2">
                            <a class="text-danger fw-semibold" 
                               href="?pid=<?php echo base64_encode('presentacion/Pasajero/registrarPasajero.php'); ?>">
                                ¿No tienes cuenta? <span class="text-decoration-underline">Regístrate aquí</span>
                            </a>
                        </div>

                    </form>
                    <?php
                    if($error == 1){
                        echo "<div class='alert alert-danger text-center fw-semibold'>
                            Correo o clave incorrectos.
                        </div>";
                    }else if($error == 2){
                        echo "<div class='alert alert-warning text-center fw-semibold'>
                            Su cuenta está inactiva. Por favor, revise su correo para activarla.
                        </div>";
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
