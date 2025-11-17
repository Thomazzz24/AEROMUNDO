<body>
	<!-- NAVBAR -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow">
		<div class="container">
			<a class="navbar-brand d-flex align-items-center" href="#">
				<img src="img/logo.jpg" alt="Logo" width="40" height="40" class="me-2">
				AeroMundo Viajes
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="menu">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item">
						<a class="nav-link active" href="?pid=<?php echo base64_encode('presentacion/sesionAdmin.php'); ?>">Inicio</a>
					</li>
					<li class="nav-item"><a class="nav-link" href="#">Vuelos</a></li>
					<li class="nav-item"><a class="nav-link" href="#">Reservar</a></li>
					<li class="nav-item"><a class="nav-link" href="#">Check-in</a></li>
					<li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
				</ul>
				<a href="?pid=<?php echo base64_encode('autenticar.php'); ?>" class="btn btn-outline-primary ms-3">
					<i class="fa-solid fa-user me-1"></i> Iniciar Sesión
				</a>
			</div>
		</div>
	</nav>

	<!-- CARRUSEL -->
	<div id="carousel" class="carousel slide mt-5 pt-4" data-bs-ride="carousel">
		<div class="carousel-indicators">
			<button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active"></button>
			<button type="button" data-bs-target="#carousel" data-bs-slide-to="1"></button>
		</div>

		<div class="carousel-inner">
			<div class="carousel-item active">
				<img src="img/carrusel1.jpg" class="d-block w-100 rounded" alt="Viajes por el mundo"
					style="height: 400px; object-fit: cover;">
				<div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
					<h3>Descubre el mundo con nosotros</h3>
					<p>Encuentra vuelos económicos y destinos soñados.</p>
				</div>
			</div>
			<div class="carousel-item">
				<img src="img/carrusel2.jpg" class="d-block w-100 rounded" alt="Aventura"
					style="height: 400px; object-fit: cover;">
				<div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
					<h3>Explora sin límites</h3>
					<p>Ofertas únicas a los mejores destinos turísticos.</p>
				</div>
			</div>
		</div>

		<button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
			<span class="carousel-control-prev-icon"></span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
			<span class="carousel-control-next-icon"></span>
		</button>
	</div>

	<!-- DESTINOS POPULARES -->
	<div class="container my-5">
		<h2 class="text-center mb-4">Destinos Populares</h2>
		<div class="row row-cols-1 row-cols-md-3 g-4">
			<div class="col">
				<div class="card h-100 shadow-sm">
					<img src="img/paris.jpg" class="card-img-top" alt="París">
					<div class="card-body">
						<h5 class="card-title">París</h5>
						<p class="card-text">Vuela a la ciudad del amor y disfruta su historia, arte y gastronomía.</p>
						<p class="fw-bold">Desde $2.400.000 COP</p>
						<button class="btn btn-primary w-100">
							<i class="fa-solid fa-plane-departure me-1"></i> Reservar vuelo
						</button>
					</div>
				</div>
			</div>

			<div class="col">
				<div class="card h-100 shadow-sm">
					<img src="img/cartagena.jpg" class="card-img-top" alt="Cartagena">
					<div class="card-body">
						<h5 class="card-title">Cartagena</h5>
						<p class="card-text">Playas caribeñas, historia y cultura colonial en un solo destino.</p>
						<p class="fw-bold">Desde $420.000 COP</p>
						<button class="btn btn-primary w-100">
							<i class="fa-solid fa-plane-departure me-1"></i> Reservar vuelo
						</button>
					</div>
				</div>
			</div>

			<div class="col">
				<div class="card h-100 shadow-sm">
					<img src="img/madrid.jpg" class="card-img-top" alt="Madrid">
					<div class="card-body">
						<h5 class="card-title">Madrid</h5>
						<p class="card-text">Descubre la energía y cultura de una de las capitales más vibrantes de Europa.</p>
						<p class="fw-bold">Desde $3.000.000 COP</p>
						<button class="btn btn-primary w-100">
							<i class="fa-solid fa-plane-departure me-1"></i> Reservar vuelo
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- FOOTER -->
	<footer class="bg-light text-center text-muted py-4 mt-5 border-top">
		<div class="container">
			<p class="mb-1">© 2025 AeroMundo Viajes - Todos los derechos reservados</p>
			<p>
				<i class="fa-solid fa-phone me-1"></i> +57 310 456 7890 |
				<i class="fa-solid fa-envelope ms-2 me-1"></i> contacto@aeromundo.com
			</p>
		</div>
	</footer>
</body>
