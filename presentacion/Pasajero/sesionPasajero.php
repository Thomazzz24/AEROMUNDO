<?php
$id = $_SESSION["id"];
if ($_SESSION["rol"] != 2) {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
    exit();
}

$pasajero = new Pasajero($id);
$pasajero->consultarPorId();
?>

<body>
<?php include "menuPasajero.php"; ?>

<div class="container mt-4">
    <?php
    if (isset($_GET["pid"])) {
        include(base64_decode($_GET["pid"]));
    } else {
        include("inicioPasajero.php");
    }
    ?>
</div>
</body>
