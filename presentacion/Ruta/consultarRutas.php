<?php
require_once("logica/ruta.php");

$id = $_SESSION["id"];
if ($_SESSION["rol"] != "admin") {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
    exit();
}

$admin = new Admin($id);
$admin->consultarPorId();

$ruta = new Ruta();
$listaRutas = $ruta->consultarTodos();

$mensaje = "";
if (isset($_GET["eliminar"])) {
    $idRutaAEliminar = $_GET["eliminar"];
    $rutaAEliminar = new Ruta($idRutaAEliminar);
    $rutaAEliminar->eliminar();
    $mensaje = "<div class='alert alert-success mt-3 text-center' role='alert'>
                    Ruta eliminada exitosamente.
                </div>";
}
?>

<body>
<?php include 'presentacion/administrador/menuAdministrador.php'; ?>

<div class="container mt-4">
    <h3>Listado de Rutas</h3>
    <hr>
    <?php 
    if($mensaje != "") {
        echo $mensaje;
    }
    ?>

    <?php if(count($listaRutas) > 0) { ?>
        <table class="table table-striped table-hover table-bordered text-center align-middle">
            <thead class="table-danger">
                <tr>
                    <th>ID</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Duración</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($listaRutas as $r) { ?>
                    <tr>
                        <td><?= $r->getId() ?></td>
                        <td><?= $r->getOrigen() ?></td>
                        <td><?= $r->getDestino() ?></td>
                        <td><?= $r->getDuracion() ?></td>
                        <td>
                            <a href='?pid=<?= base64_encode("presentacion/Ruta/editarRuta.php") ?>&idRuta=<?= $r->getId() ?>' title='Editar'>
                                <i class='fa-solid fa-pen-to-square text-primary fs-4 me-2'></i>
                            </a>
                            <a href='?pid=<?= base64_encode("presentacion/Ruta/consultarRutas.php") ?>&eliminar=<?= $r->getId() ?>' title='Eliminar' 
                                onclick='return confirm("¿Estás seguro de eliminar esta ruta?")'>
                                <i class='fa-solid fa-trash text-danger fs-4'></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="alert alert-warning text-center">
            No hay rutas registradas.
        </div>
    <?php } ?>
</div>
</body>
