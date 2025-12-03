<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("logica/Vuelo.php");
require_once("logica/tiquete.php");
require_once("logica/Pasajero.php");

// Validar que haya sesión activa
if (!isset($_SESSION["id"]) || !isset($_SESSION["rol"])) {
    header('Location: ?pid=' . base64_encode("autenticacion/autenticar.php"));
    exit();
}

include "presentacion/Pasajero/menuPasajero.php"; 

// Obtener ID del vuelo
$idVuelo = $_GET["idVuelo"] ?? 0;

if ($idVuelo == 0) {
    echo "<div class='container mt-5'>
            <div class='alert alert-danger'>Vuelo no válido.</div>
          </div>";
    exit();
}

// Cargar datos del vuelo
$vuelo = new Vuelo($idVuelo);
if (!$vuelo->consultarPorId()) {
    echo "<div class='container mt-5'>
            <div class='alert alert-danger'>Vuelo no encontrado.</div>
          </div>";
    exit();
}

// Validar que el vuelo sea futuro
if (strtotime($vuelo->getFecha_salida()) < time()) {
    echo "<div class='container mt-5'>
            <div class='alert alert-warning'>Este vuelo ya partió. No es posible comprarlo.</div>
            <a href='?pid=" . base64_encode('presentacion/pasajero/consultarVuelos.php') . "' class='btn btn-primary'>Ver otros vuelos</a>
          </div>";
    exit();
}

// Cargar datos del comprador
$comprador = new Pasajero($_SESSION["id"]);
$comprador->consultarPorId();

// Obtener disponibilidad
$tiquete = new Tiquete();
$disponibilidad = $tiquete->validarDisponibilidad($idVuelo, 1);

// Variables para mensajes
$mensaje = "";
$tipoMensaje = "";

// PROCESAR COMPRA
if (isset($_POST["comprar"])) {
    
    $nombres = $_POST["pasajeros"] ?? [];
    $documentos = $_POST["documentos"] ?? [];
    
    // Validar que haya datos
    if (empty($nombres) || empty($documentos)) {
        $mensaje = "Debe ingresar al menos un pasajero.";
        $tipoMensaje = "danger";
    } else {
        
        $cantidad = count($nombres);
        
        // Validar disponibilidad
        $disponibilidad = $tiquete->validarDisponibilidad($idVuelo, $cantidad);
        
        if (!$disponibilidad['disponible']) {
            $mensaje = "No hay suficientes asientos disponibles. Solo quedan " . $disponibilidad['disponibles'] . " asientos.";
            $tipoMensaje = "warning";
        } else {
            
            // Procesar cada pasajero
            $tiquetesGenerados = [];
            $error = false;
            
            for ($i = 0; $i < $cantidad; $i++) {
                
                $nombrePasajero = trim($nombres[$i]);
                $documentoPasajero = trim($documentos[$i]);
                
                // Validaciones
                if (empty($nombrePasajero) || empty($documentoPasajero)) {
                    $mensaje = "Todos los campos son obligatorios.";
                    $tipoMensaje = "danger";
                    $error = true;
                    break;
                }
                
                // Generar asiento automático
                $asiento = $tiquete->generarAsientoDisponible($idVuelo);
                
                if ($asiento === null) {
                    $mensaje = "No hay más asientos disponibles.";
                    $tipoMensaje = "danger";
                    $error = true;
                    break;
                }
                
                // Determinar si el pasajero es el comprador (para guardar id_pasajero)
                $idPasajero = null;
                $nombreCompletoComprador = trim($comprador->getNombre() . " " . $comprador->getApellido());
                
                if (strtolower($nombrePasajero) == strtolower($nombreCompletoComprador)) {
                    $idPasajero = $comprador->getId();
                }
                
                // Crear tiquete
                $nuevoTiquete = new Tiquete(
                    0,
                    $comprador->getId(),  // id_comprador (quien compra)
                    $idVuelo,
                    $idPasajero,          // id_pasajero (si es el mismo que compra, sino NULL)
                    $nombrePasajero,
                    $documentoPasajero,
                    $asiento,
                    $vuelo->getPrecio()
                );
                
                $idGenerado = $nuevoTiquete->insertar();
                
                if ($idGenerado > 0) {
                    $tiquetesGenerados[] = [
                        'nombre' => $nombrePasajero,
                        'documento' => $documentoPasajero,
                        'asiento' => $asiento,
                        'precio' => $vuelo->getPrecio()
                    ];
                } else {
                    $mensaje = "Error al procesar el tiquete del pasajero: $nombrePasajero";
                    $tipoMensaje = "danger";
                    $error = true;
                    break;
                }
            }
            
            if (!$error) {
                $mensaje = "¡Compra realizada exitosamente! Se generaron " . count($tiquetesGenerados) . " tiquete(s).";
                $tipoMensaje = "success";
            }
        }
    }
}

// Actualizar disponibilidad después de comprar
$disponibilidad = $tiquete->validarDisponibilidad($idVuelo, 1);
?>

<div class="container mt-5">
    
    <!-- INFORMACIÓN DEL VUELO -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">
                <i class="fa-solid fa-plane-departure me-2"></i>
                Comprar Tiquete
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-danger">
                        <?= $vuelo->getOrigen() ?> 
                        <i class="fa-solid fa-arrow-right mx-2"></i> 
                        <?= $vuelo->getDestino() ?>
                    </h5>
                    <p class="mb-1">
                        <strong>Fecha de salida:</strong> 
                        <?= date('d/m/Y H:i', strtotime($vuelo->getFecha_salida())) ?>
                    </p>
                    <p class="mb-1">
                        <strong>Fecha de llegada:</strong> 
                        <?= date('d/m/Y H:i', strtotime($vuelo->getFecha_llegada())) ?>
                    </p>
                    <p class="mb-0">
                        <strong>Avión:</strong> <?= $vuelo->getModelo() ?>
                    </p>
                </div>
                <div class="col-md-6 text-end">
                    <h3 class="text-danger mb-3">
                        $<?= number_format($vuelo->getPrecio(), 0, ',', '.') ?>
                        <small class="text-muted fs-6">por persona</small>
                    </h3>
                    <p class="mb-1">
                        <i class="fa-solid fa-chair text-success me-1"></i>
                        <strong>Disponibles:</strong> <?= $disponibilidad['disponibles'] ?> / <?= $disponibilidad['capacidad'] ?>
                    </p>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: <?= ($disponibilidad['disponibles'] / $disponibilidad['capacidad']) * 100 ?>%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MENSAJES -->
    <?php if ($mensaje != ""): ?>
        <div class="alert alert-<?= $tipoMensaje ?> alert-dismissible fade show" role="alert">
            <?= $mensaje ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        
        <?php if ($tipoMensaje == "success" && !empty($tiquetesGenerados)): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Resumen de Tiquetes</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Pasajero</th>
                                <th>Documento</th>
                                <th>Asiento</th>
                                <th class="text-end">Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total = 0;
                            foreach ($tiquetesGenerados as $t): 
                                $total += $t['precio'];
                            ?>
                                <tr>
                                    <td><?= $t['nombre'] ?></td>
                                    <td><?= $t['documento'] ?></td>
                                    <td><span class="badge bg-primary"><?= $t['asiento'] ?></span></td>
                                    <td class="text-end">$<?= number_format($t['precio'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="3" class="text-end">TOTAL:</td>
                                <td class="text-end">$<?= number_format($total, 0, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="text-center mt-3">
                        <a href="?pid=<?= base64_encode('presentacion/Pasajero/misTiquetes.php') ?>" 
                           class="btn btn-primary">
                            <i class="fa-solid fa-ticket me-2"></i>
                            Ver Mis Tiquetes
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- FORMULARIO -->
    <?php if ($disponibilidad['disponibles'] > 0): ?>
    <form method="POST" id="formCompra">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Datos de los Pasajeros</h5>
                <span class="badge bg-light text-dark">
                    <span id="contadorPasajeros">1</span> pasajero(s)
                </span>
            </div>
            <div class="card-body">
                
                <div id="contenedorPasajeros">
                    <!-- Primer pasajero (el comprador) -->
                    <div class="pasajero-item border rounded p-3 mb-3">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Nombre completo</label>
                                <input type="text" name="pasajeros[]" class="form-control"
                                    value="<?= $comprador->getNombre() . ' ' . $comprador->getApellido(); ?>" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Documento</label>
                                <input type="text" name="documentos[]" class="form-control"
                                    placeholder="Ej: 1234567890" required>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-outline-secondary btn-sm mb-3" onclick="agregarPasajero()">
                    <i class="fa-solid fa-plus me-1"></i>
                    Añadir otro pasajero
                </button>

                <hr>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Total a pagar:</h5>
                        <h3 class="text-danger mb-0" id="totalPagar">
                            $<?= number_format($vuelo->getPrecio(), 0, ',', '.') ?>
                        </h3>
                    </div>
                    <div>
                        <button class="btn btn-danger btn-lg" type="submit" name="comprar">
                            <i class="fa-solid fa-check me-2"></i>
                            Confirmar Compra
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>
    <?php else: ?>
        <div class="alert alert-warning">
            <i class="fa-solid fa-exclamation-triangle me-2"></i>
            Lo sentimos, este vuelo está completamente lleno.
        </div>
    <?php endif; ?>

    <div class="text-center mt-4 mb-5">
        <a href="?pid=<?= base64_encode('presentacion/Pasajero/consultarVuelos.php') ?>" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Volver a Vuelos
        </a>
    </div>

</div>

<script>
const precioPorPasajero = <?= $vuelo->getPrecio() ?>;

function agregarPasajero() {
    let contador = document.querySelectorAll('.pasajero-item').length;
    
    let div = document.createElement("div");
    div.className = "pasajero-item border rounded p-3 mb-3 position-relative";
    div.innerHTML = `
        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" 
                onclick="eliminarPasajero(this)">
            <i class="fa-solid fa-times"></i>
        </button>
        <div class="row">
            <div class="col-md-6 mb-2">
                <label class="form-label">Nombre completo</label>
                <input type="text" name="pasajeros[]" class="form-control" placeholder="Nombre completo del pasajero" required>
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label">Documento</label>
                <input type="text" name="documentos[]" class="form-control" placeholder="Ej: 1234567890" required>
            </div>
        </div>
    `;
    
    document.getElementById("contenedorPasajeros").appendChild(div);
    actualizarTotal();
}

function eliminarPasajero(btn) {
    btn.closest('.pasajero-item').remove();
    actualizarTotal();
}

function actualizarTotal() {
    let cantidad = document.querySelectorAll('.pasajero-item').length;
    document.getElementById('contadorPasajeros').textContent = cantidad;
    
    let total = cantidad * precioPorPasajero;
    document.getElementById('totalPagar').textContent = '$' + total.toLocaleString('es-CO');
}
</script>