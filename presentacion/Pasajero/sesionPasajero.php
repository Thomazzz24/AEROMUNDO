<?php
$id = $_SESSION["id"];
if (isset($_SESSION["id"]) && isset($_SESSION["rol"]) && $_SESSION["rol"] == "pasajero") {
    $pasajero = new Pasajero($_SESSION["id"]);
    $pasajero->consultarPorId();
} else {
    header("Location: ?pid=" . base64_encode("autenticacion/noAutorizado.php"));
    exit();
}
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
