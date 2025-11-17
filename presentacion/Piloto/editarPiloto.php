<?php
require_once("logica/Persona.php");
require_once("logica/Admin.php");
require_once("logica/Piloto.php");

$id = $_SESSION["id"];
if ($_SESSION["rol"] != "admin") {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
    exit();
    }
$admin = new Admin($id);
$admin->consultarPorId();

if(!isset($_GET["pilotoId"])){
    $mensaje = "<div class='alert alert-danger mt-3 text-center' role='alert'>
                    ID de piloto no proporcionado.
                </div>";
}

$pilotoId = $_GET["pilotoId"];
$piloto = new Piloto($pilotoId);
$piloto->consultarPorId();

if(isset($_POST["editar"])){
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $correo = $_POST["correo"];

    $imagenNueva = $piloto->getFotoPerfil();
    if(isset($_FILES["foto_perfil"]) && $_FILES["foto_perfil"]["error"] == 0){
        $imagenNombre = time() . "." . pathinfo($_FILES["foto_perfil"]["name"], PATHINFO_EXTENSION);
        $imagenRutalocal = $_FILES["foto_perfil"]["tmp_name"];
        $rutaDedestino = $_SERVER["DOCUMENT_ROOT"] . "/AgenciaViajes/imagenes/" . $imagenNombre;
        if(move_uploaded_file($imagenRutalocal, $rutaDedestino)){
            $imagenAnterior = $piloto->getFotoPerfil();
            if($imagenAnterior != null && $imagenAnterior != "" && file_exists($_SERVER["DOCUMENT_ROOT"] . "/AgenciaViajes/presentacion/imagenes/" . $imagenAnterior)){
                unlink($_SERVER["DOCUMENT_ROOT"] . "/AgenciaViajes/presentacion/imagenes/" . $imagenAnterior);
            }
            $imagenNueva = $imagenNombre;
        }else{
            $mensaje = "<div class='alert alert-danger mt-3 text-center' role='alert'>
                            Error al subir la imagen.
                        </div>";
        }
        
    }
    $piloto->setNombre($nombre);
    $piloto->setApellido($apellido);
    $piloto->setCorreo($correo);
    $piloto->setFotoPerfil($imagenNueva);
    $piloto->editar();
    $piloto->consultarPorId();
    $mensaje = "<div class='alert alert-success mt-3 text-center' role='alert'>
                    Piloto editado exitosamente.
                </div>";
    

}
?>
<body>
<?php include 'presentacion/administrador/menuAdministrador.php'; ?>
<div class="container">
    <div class="row mt-5">
        <div class="col-4"></div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h3>Editar Piloto</h3>
                </div>
                <div class="card-body">
                    <?php 
                    if(isset($mensaje)){
                        echo $mensaje;
                    }
                    ?>
                    <form method="post" enctype="multipart/form-data" 
                    action="?pid=<?php echo base64_encode('presentacion/Piloto/editarPiloto.php'); ?>&pilotoId=<?php echo $pilotoId; ?>" >
                        <div class="mb-3">
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php echo $piloto->getNombre(); ?>" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="apellido" placeholder="Apellido" value="<?php echo $piloto->getApellido(); ?>" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" name="correo" placeholder="Correo" value="<?php echo $piloto->getCorreo(); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto_perfil" class="form-label">Foto de Perfil Actual</label>
                            <?php   
                            if($piloto->getFotoPerfil() != null && $piloto->getFotoPerfil() != "") {
                                echo "<img src='imagenes/" . $piloto->getFotoPerfil() . "' alt='Foto de Perfil' width='100' height='100' class='mt-2'>";
                            }
                            
                            ?>
                            <input type="file" class="form-control" name="foto_perfil" id="foto_perfil" accept="image/*">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" name="editar">Guardar Cambios</button>
                            <a href="?pid=<?php echo base64_encode('presentacion/Piloto/consultarPiloto.php'); ?>" 
                            class="btn btn-secondary mt-2">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-4"></div>
    </div>
</div>
</body>