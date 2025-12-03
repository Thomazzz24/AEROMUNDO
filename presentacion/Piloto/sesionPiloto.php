<?php
$id = $_SESSION["id"];
if (isset($_SESSION["id"]) && isset($_SESSION["rol"]) && $_SESSION["rol"] == "piloto") {
    $piloto = new Piloto($_SESSION["id"]);
    $piloto->consultarPorId();
} else {
    header("Location: ?pid=" . base64_encode("presentacion/autenticacion/noAutorizado.php"));
    exit();
}

// Incluir el menú
include "menuPiloto.php";
?>

<div class="container mt-4">
    <?php
    if (isset($_GET["pid"])) {
        $page = base64_decode($_GET["pid"]);
        
        // IMPORTANTE: Evitar incluir sesionPiloto.php recursivamente
        if (strpos($page, 'sesionPiloto.php') === false) {
            include($page);
        } else {
            // Si intenta cargar sesionPiloto.php, mostrar la página de inicio
            include("inicioPiloto.php");
        }
    } else {
        include("inicioPiloto.php");
    }
    ?>
</div>