<?php
session_start();

require_once("logica/Persona.php");
require_once("logica/Admin.php");
require_once("logica/Piloto.php");
require_once("logica/Pasajero.php");
require_once("logica/Vuelo.php");
require_once("logica/Avion.php");
require_once("logica/ruta.php");


if (isset($_GET["salir"])) {
    session_unset();
    session_destroy();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>AEROMUNDO</title>
<link
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
	rel="stylesheet">
<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script
	src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script
	src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
</head>
<?php
if (! isset($_GET["pid"])) {
    include ("presentacion/inicio.php");
} else {
    $pid = base64_decode($_GET["pid"]);
    if (isset($_SESSION["id"])) {
        include ($pid);
    } else {
        include ($pid);
        // TODO reparar esto
    }
}
?>
</html>
