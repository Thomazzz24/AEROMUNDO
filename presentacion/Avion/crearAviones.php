<?php
if (!isset($_SESSION["id"]) || $_SESSION["rol"] != "admin") {
    header("Location: ?pid=" . base64_encode("noAutorizado.php"));
}

include_once("logica/Avion.php");

$mensaje = "";

if (isset($_POST["registrar"])) {
    $modelo = $_POST["modelo"];
    $capacidad = $_POST["capacidad"];

    $avion = new Avion("", $modelo, $capacidad, 1);
    $avion->registrar();

    $mensaje = "<div class='alert alert-success'>Avión registrado correctamente</div>";
}
?>

<div class="container mt-4">
    <h3>Registrar Avión</h3>
    <hr>

    <?= $mensaje ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Modelo</label>
            <input type="text" class="form-control" name="modelo" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Capacidad</label>
            <input type="number" class="form-control" name="capacidad" min="1" required>
        </div>

        <button type="submit" name="registrar" class="btn btn-primary">
            Registrar
        </button>
    </form>
</div>
