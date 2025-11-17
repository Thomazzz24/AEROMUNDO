<?php

require_once("logica/Persona.php");
require_once("logica/Admin.php");
require_once("logica/Piloto.php");
require_once("logica/Pasajero.php");
$error = false;

if (isset($_POST["autenticar"])) {
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];

    $admin = new Admin(0, "", "", $correo, $clave);
    if ($admin->autenticar()) {
        $_SESSION["id"] = $admin->getId();
        $_SESSION["rol"] = "admin";
        header("Location: ?pid=" . base64_encode("presentacion/sesionAdmin.php"));
        exit();
    }

    $piloto = new Piloto(0, "", "", $correo, $clave);
    if ($piloto->autenticar()) {
        $_SESSION["id"] = $piloto->getId();
        $_SESSION["rol"] = "piloto";
        header("Location: ?pid=" . base64_encode("presentacion/sesionPiloto.php"));
        exit();
    }

    $pasajero = new Pasajero(0, "", "", $correo, $clave);
    if ($pasajero->autenticar()) {
        $_SESSION["id"] = $pasajero->getId();
        $_SESSION["rol"] = "pasajero";
        header("Location: ?pid=" . base64_encode("presentacion/sesionPasajero.php"));
        exit();
    }

    $error = true;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aerolinea - Autenticación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-4">

            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="m-0">Iniciar Sesión</h4>
                </div>

                <div class="card-body">

                    <?php if ($error) { ?>
                        <div class="alert alert-danger">
                            Correo o clave incorrectos.
                        </div>
                    <?php } ?>

                    <form method="post" action="?pid=<?php echo base64_encode("autenticacion/autenticar.php") ?>"
>
                        
                        <div class="mb-3">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" name="correo" placeholder="correo@ejemplo.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Clave</label>
                            <input type="password" class="form-control" name="clave" placeholder="*******" required>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" name="autenticar" class="btn btn-primary">
                                Ingresar
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="?pid=<?php echo base64_encode('presentacion/Pasajero/registrarPasajero.php'); ?>">
                                ¿No tienes cuenta? Regístrate aquí
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
