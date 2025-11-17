<nav class="navbar navbar-expand-lg navbar-primary bg-primary shadow">
	<div class="container-fluid">
		<!-- Logo -->
		<a class="navbar-brand fw-bold d-flex align-items-center" href="#"> <img
			src="img/logo.jpg" alt="Logo" width="40" height="40"
			class="me-2 rounded-circle"> AEROMUNDO
		</a>

		<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
			data-bs-target="#menu">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="menu">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item"><a class="nav-link active text" href="?pid=<?php echo base64_encode("presentacion/sesionAdmin.php") ?>">Inicio</a></li>
				<li class="nav-item"><a class="nav-link active text" href="#">Servicio
						para admin</a></li>
				<li class="nav-item dropdown"><a class="nav-link dropdown-toggle"
					href="#" role="button" data-bs-toggle="dropdown"
					aria-expanded="false"> Pilotos </a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item"
							href="?pid=<?php echo base64_encode("presentacion/Piloto/crearPiloto.php") ?>">Registrar
								Pilotos</a></li>
						<li><a class="dropdown-item"
							href="?pid=<?php echo base64_encode("presentacion/Piloto/consultarPiloto.php") ?>">Consultar
								Pilotos</a></li>
						<li><a class="dropdown-item"
							href="?pid=<?php echo base64_encode("presentacion/Piloto/buscarPiloto.php") ?>">Busccar
								Pilotos</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item" href="#">Something else here</a></li>
					</ul>
				</li>
				<li class="nav-item dropdown"><a class="nav-link dropdown-toggle"
					href="#" role="button" data-bs-toggle="dropdown"
					aria-expanded="false"> Clientes </a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item"
							href="?pid=<?php echo base64_encode("presentacion/Pasajero/consultarPasajero.php") ?>">Consultar
								Clientes/Pasajeros</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item" href="#">Something else here</a></li>
					</ul>
				</li>
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle"
					href="#" role="button" data-bs-toggle="dropdown"
					aria-expanded="false"> Aviones </a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item"
							href="?pid=<?php echo base64_encode("presentacion/producto/crearProducto.php") ?>">Registrar
								Aviones</a></li>
						<li><a class="dropdown-item"
							href="?pid=<?php echo base64_encode("presentacion/producto/consultarProducto.php") ?>">Consultar
								Aviones</a></li>
						<li><a class="dropdown-item"
							href="?pid=<?php echo base64_encode("presentacion/producto/buscarProducto.php") ?>">Busccar
								Aviones</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item" href="#">Something else here</a></li>
					</ul>
				</li>
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle"
					href="#" role="button" data-bs-toggle="dropdown"
					aria-expanded="false"> Rutas </a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item"
							href="?pid=<?php echo base64_encode("presentacion/producto/crearProducto.php") ?>">Registrar
								Rutas</a></li>
						<li><a class="dropdown-item"
							href="?pid=<?php echo base64_encode("presentacion/producto/consultarProducto.php") ?>">Consultar
								Rutas</a></li>
						<li><a class="dropdown-item"
							href="?pid=<?php echo base64_encode("presentacion/producto/buscarProducto.php") ?>">Busccar
								Rutas</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item" href="#">Something else here</a></li>
					</ul>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle"
					href="#" role="button" data-bs-toggle="dropdown"
					aria-expanded="false"> Vuelos </a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item"
							href="?pid=<?php echo base64_encode("presentacion/producto/crearProducto.php") ?>">Registrar
								Vuelos</a></li>
						<li><a class="dropdown-item"
							href="?pid=<?php echo base64_encode("presentacion/producto/consultarProducto.php") ?>">Consultar
								Vuelos</a></li>
						<li><a class="dropdown-item"
							href="?pid=<?php echo base64_encode("presentacion/producto/buscarProducto.php") ?>">Busccar
								Vuelos</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item" href="#">Something else here</a></li>
					</ul>
				</li>
				</li>
			</ul>
			<!-- Dropdown con nombre y apellido -->
			<ul class="navbar-nav ms-auto">
				<li class="nav-item dropdown"><a
					class="nav-link dropdown-toggle d-flex align-items-center" href="#"
					role="button" data-bs-toggle="dropdown" aria-expanded="false"> <i
						class="fa-solid fa-user-circle me-2"></i>Administrador: 
            <?php echo $admin -> getNombre() . " " . $admin -> getApellido() ?>
          </a>
					<ul class="dropdown-menu dropdown-menu-end shadow">
						<li><a class="dropdown-item" href="editarPerfil.php"><i
								class="fa-solid fa-user-pen me-2"></i> Editar Perfil</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item text-danger" href="?salir=true"> <i
								class="fa-solid fa-right-from-bracket me-2"></i> Salir
						</a></li>
					</ul></li>
			</ul>
		</div>
	</div>
</nav>
