<?php
$id = $_SESSION["id"];
if ($_SESSION["rol"] != "admin") {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
}
$admin = new Admin($id);
$admin->consultarPorId();

if (isset($_POST["crearPiloto"])) {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $imagenNombre = time() . "." . pathinfo($_FILES["foto_perfil"]["name"], PATHINFO_EXTENSION);
    echo $imagenNombre;
    $imagenRutaLocal = $_FILES["foto_perfil"]["tmp_name"];
    copy($imagenRutaLocal, "imagenes/" . $imagenNombre);
    $piloto = new Piloto(0, $nombre, $apellido, $correo, $clave, "", 1, "", $imagenNombre);
    $piloto->registrar();
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
						<h3>Crear Piloto</h3>
					</div>
					<div class="card-body">
						<?php 
						if(isset($_POST["crearPiloto"])){
						    echo "<div class='alert alert-success' role='alert'>
                                    Piloto almacenado exitosamente!
                                    </div>";
						}
						?>
						<form method="post" enctype="multipart/form-data" action="?pid=<?php echo base64_encode("presentacion/Piloto/crearPiloto.php")?>">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="nombre"
                                        placeholder="Nombre" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="apellido"
                                        placeholder="Apellido" required>
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control" name="correo"
                                        placeholder="Correo" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control" name="clave"
                                        placeholder="Clave" required>
                                </div>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Foto de Perfil</label>
                                    <input class="form-control" type="file" id="formFile" name="foto_perfil" required>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary" name="crearPiloto">Crear</button>
                                </div>
                            </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>	