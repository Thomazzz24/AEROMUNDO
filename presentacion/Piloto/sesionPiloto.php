<?php
$id = $_SESSION["id"];
if (isset($_SESSION["id"]) && isset($_SESSION["rol"]) && $_SESSION["rol"] == "piloto") {
    $piloto = new Piloto($_SESSION["id"]);
    $piloto->consultarPorId();
} else {
    header("Location: ?pid=" . base64_encode("presentacion/autenticacion/noAutorizado.php"));
    exit();
}

include "menuPiloto.php";
?>

<div class="container mt-4">
    <?php
    if (isset($_GET["pid"])) {
        $page = base64_decode($_GET["pid"]);
        if (strpos($page, 'sesionPiloto.php') === false) {
            include($page);
        } else {
            include("inicioPiloto.php");
        }
    } else {
        include("inicioPiloto.php");
    }
    ?>
</div>