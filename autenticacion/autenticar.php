<?php
require_once("logica/Persona.php");
require_once("logica/Admin.php");
require_once("logica/Piloto.php");
require_once("logica/Pasajero.php");

$error = 0;

$redir = isset($_GET["redir"]) ? $_GET["redir"] : null;

if (isset($_POST["autenticar"])) {

    if (isset($_POST["redir"])) {
        $redir = $_POST["redir"];
    }

    $correo = $_POST["correo"];
    $clave = $_POST["clave"];

    $admin = new Admin(0, "", "", $correo, $clave);
    if ($admin->autenticar()) {
        $_SESSION["id"] = $admin->getId();
        $_SESSION["rol"] = "admin";
        header("Location: ?pid=" . base64_encode("presentacion/administrador/sesionAdmin.php"));
        exit();
    }

    $pasajero = new Pasajero(0, "", "", $correo, $clave);

    if ($pasajero->autenticar()) {

        if ($pasajero->getEstado()) {

            $_SESSION["id"] = $pasajero->getId();
            $_SESSION["rol"] = "pasajero";

            if ($redir) {
                header("Location: ?pid=" . base64_encode("presentacion/Pasajero/comprarTiquete.php") . "&idVuelo=" . $redir);
                exit();
            }

            header("Location: ?pid=" . base64_encode("presentacion/pasajero/menuPasajero.php"));
            exit();

        } else {
            $error = 2;
        }
    }

    $piloto = new Piloto(0, "", "", $correo, $clave);
    if ($piloto->autenticar()) {
        $_SESSION["id"] = $piloto->getId();
        $_SESSION["rol"] = "piloto";
        header("Location: ?pid=" . base64_encode("presentacion/piloto/sesionPiloto.php"));
        exit();
    }

    $error = 1;
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

                <div class="card-header text-center bg-danger text-white rounded-top-4 py-4">
                    <i class="fa-solid fa-circle-user fa-3x mb-2"></i>
                    <h4 class="fw-bold m-0">Iniciar Sesión</h4>
                </div>

                <div class="card-body p-4">

                    <?php if ($error == 1) { ?>
                        <div class="alert alert-danger text-center fw-semibold">
                            Correo o clave incorrectos.
                        </div>
                    <?php } ?>

                    <?php if ($error == 2) { ?>
                        <div class="alert alert-warning text-center fw-semibold">
                            Su cuenta está inactiva. Revise su correo para activarla.
                        </div>
                    <?php } ?>

                    <form method="post" action="?pid=<?= base64_encode('autenticacion/autenticar.php') ?>">

                        <input type="hidden" name="redir" value="<?= $redir ?>">

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-danger">Correo electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text bg-danger text-white">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" name="correo" placeholder="ejemplo@aero.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-danger">Clave</label>
                            <div class="input-group">
                                <span class="input-group-text bg-danger text-white">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" name="clave" placeholder="******" required>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" name="autenticar" class="btn btn-danger fw-semibold">
                                <i class="fa-solid fa-right-to-bracket me-1"></i> Ingresar
                            </button>
                        </div>

                        <div class="text-center mt-2">
                            <a class="text-danger fw-semibold" 
                                href="?pid=<?= base64_encode('presentacion/Pasajero/registrarPasajero.php') ?>">
                                ¿No tienes cuenta? <u>Regístrate aquí</u>
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
