<?php
require_once("logica/Persona.php");
require_once("logica/Pasajero.php");

$success = "";
$error = "";

if(isset($_POST["registrar"])){
    
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $confirmarClave = $_POST["confirmarClave"];

    if($clave !== $confirmarClave){
        $error = "Las contraseñas no coinciden.";
    } else {
        $pasajero = new Pasajero(0, $nombre, $apellido, $correo, $clave);
        $pasajero->registrar();

        $success = "Cliente almacenado correctamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>AEROMUNDO</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="row mt-5">
			<div class="col-4"></div>
			<div class="col-4">
				<div class="card">
					<div class="card-header">
						<h3>Registrar Cliente</h3>
					</div>
					<div class="card-body">
                        <?php if($error != "") { ?>
                            <div class='alert alert-danger text-center'><?php echo $error; ?></div>
                        <?php } ?>
                        <?php if($success != "") { ?>
                            <div class='alert alert-success text-center'><?php echo $success; ?></div>
                        <?php } ?>
						<form method="post" action="?pid=<?php echo base64_encode('presentacion/Pasajero/registrarPasajero.php'); ?>">
							
                            <div class="mb-3">
								<input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
							</div>
							<div class="mb-3">
								<input type="text" class="form-control" name="apellido" placeholder="Apellido" required>
							</div>
							<div class="mb-3">
								<input type="email" class="form-control" name="correo" placeholder="Correo" required>
							</div>
							<div class="mb-3">
								<input type="password" class="form-control" name="clave" placeholder="Clave" required>
							</div>
                            <div class="mb-3">
                                <input type="password" class="form-control" name="confirmarClave" placeholder="Confirmar Clave" required>
                            </div>
							<div class="mb-3">
								<button type="submit" class="btn btn-primary w-100" name="registrar">Registrar</button>
							</div>
                            <div class="text-center">
                                <p class="text-muted">
                                    ¿Ya tienes cuenta?
                                    <a href="?pid=<?php echo base64_encode('autenticacion/autenticar.php'); ?>" class="fw-bold">
                                        Inicia sesión aquí
                                    </a>
                                </p>
                            </div>

						</form>

					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
