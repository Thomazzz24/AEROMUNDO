<?php

ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["id"]) || $_SESSION["rol"] != "pasajero") {
    die("Acceso no autorizado");
}

chdir(__DIR__ . '/../../');

require_once('logica/tiquete.php');
require_once('logica/Vuelo.php');
require_once('fpdf/fpdf.php');
require_once('phpqrcode/qrlib.php');  // ← QR

// Validar id
if (!isset($_GET["id_tiquete"]) || !is_numeric($_GET["id_tiquete"])) {
    die("ID de tiquete invalido");
}

$id_tiquete = $_GET["id_tiquete"];

// Consultar tiquete
$tiquete = new Tiquete($id_tiquete);
if (!$tiquete->consultarPorId()) {
    die("Tiquete no encontrado.");
}

// Validar permisos
$sesion_id = $_SESSION["id"];
$id_comprador = $tiquete->getId_comprador();

if ($sesion_id != $id_comprador) {
    die("No tienes permiso para ver este pasabordo.");
}

// Consultar vuelo
$vuelo = new Vuelo($tiquete->getId_vuelo());
if (!$vuelo->consultarPorId()) {
    die("Vuelo no encontrado.");
}

// Obtener datos del pasajero directamente del tiquete
$nombrePasajero = $tiquete->getNombre_pasajero();
$documentoPasajero = $tiquete->getDocumento();

if (empty($nombrePasajero)) {
    die("Nombre de pasajero no disponible en el tiquete.");
}

//
// ===========================
//     GENERAR CÓDIGO QR
// ===========================
//
$contenidoQR = "https://p1.itiud.org/presentacion/Pasajero/validarPasabordo.php?id=" . $id_tiquete;
$rutaQR = "imagenes/qr_tiquete_" . $id_tiquete . ".png";

// Crear carpeta si no existe
if (!file_exists("imagenes")) {
    mkdir("imagenes", 0777, true);
}

QRcode::png($contenidoQR, $rutaQR, QR_ECLEVEL_L, 4);

// Limpiar buffer
ob_end_clean();


//
// ===========================
//        CREAR PDF
// ===========================
//
$pdf = new FPDF("P", "mm", "Letter");
$pdf->AddPage();
$pdf->SetMargins(15, 15, 15);

//
// ===========================
//        ENCABEZADO
// ===========================
//
$pdf->SetFillColor(200, 0, 0);
$pdf->Rect(0, 0, 220, 35, 'F');

$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont("Arial", "B", 24);
$pdf->Ln(10);
$pdf->Cell(0, 10, "BOARDING PASS", 0, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->Cell(0, 5, "PASABORDO DE VUELO", 0, 1, "C");

// INSERTAR QR EN LA ESQUINA SUPERIOR DERECHA
$pdf->Image($rutaQR, 165, 5, 35);

$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(10);


//
// ===========================
//   INFORMACIÓN PRINCIPAL
// ===========================
//
$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(0, 8, utf8_decode(strtoupper($nombrePasajero)), 0, 1);
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(0, 5, "PASSENGER NAME / NOMBRE DEL PASAJERO", 0, 1);
$pdf->Ln(5);

// Línea divisoria
$pdf->SetDrawColor(200, 200, 200);
$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
$pdf->Ln(5);


//
// ===========================
//    SECCIÓN DE VUELO
// ===========================
//
$y_vuelo = $pdf->GetY();

// ORIGEN
$pdf->SetXY(15, $y_vuelo);
$pdf->SetFont("Arial", "B", 20);
$codigoOrigen = strtoupper(substr($vuelo->getOrigen(), 0, 3));
$pdf->Cell(60, 10, $codigoOrigen, 0, 1, "L");
$pdf->SetX(15);
$pdf->SetFont("Arial", "", 8);
$pdf->Cell(60, 4, "FROM / ORIGEN", 0, 1, "L");
$pdf->SetX(15);
$pdf->SetFont("Arial", "", 10);
$pdf->MultiCell(60, 4, utf8_decode($vuelo->getOrigen()), 0, "L");

// Flecha
$pdf->SetXY(75, $y_vuelo + 5);
$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(30, 10, ">>", 0, 0, "C");

// DESTINO
$pdf->SetXY(105, $y_vuelo);
$pdf->SetFont("Arial", "B", 20);
$codigoDestino = strtoupper(substr($vuelo->getDestino(), 0, 3));
$pdf->Cell(60, 10, $codigoDestino, 0, 1, "L");
$pdf->SetX(105);
$pdf->SetFont("Arial", "", 8);
$pdf->Cell(60, 4, "TO / DESTINO", 0, 1, "L");
$pdf->SetX(105);
$pdf->SetFont("Arial", "", 10);
$pdf->MultiCell(60, 4, utf8_decode($vuelo->getDestino()), 0, "L");

$pdf->Ln(8);

// Línea divisoria
$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
$pdf->Ln(5);


//
// ===========================
// DETALLES DEL VUELO
// ===========================
//
$y_detalles = $pdf->GetY();

// IZQUIERDA
$pdf->SetXY(15, $y_detalles);

// Vuelo
$pdf->SetFont("Arial", "", 8);
$pdf->Cell(90, 4, "FLIGHT / VUELO", 0, 1);
$pdf->SetX(15);
$pdf->SetFont("Arial", "B", 14);
$pdf->Cell(90, 8, $vuelo->getId_vuelo(), 0, 1);

// Fecha
$pdf->SetX(15);
$pdf->SetFont("Arial", "", 8);
$pdf->Cell(90, 4, "DATE / FECHA", 0, 1);
$pdf->SetX(15);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(90, 7, date("d/m/Y", strtotime($vuelo->getFecha_salida())), 0, 1);

// Hora
$pdf->SetX(15);
$pdf->SetFont("Arial", "", 8);
$pdf->Cell(90, 4, "TIME / HORA", 0, 1);
$pdf->SetX(15);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(90, 7, date("H:i", strtotime($vuelo->getFecha_salida())), 0, 1);

// DERECHA
$pdf->SetXY(105, $y_detalles);

// Asiento
$pdf->SetFont("Arial", "", 8);
$pdf->Cell(90, 4, "SEAT / ASIENTO", 0, 1);
$pdf->SetX(105);
$pdf->SetFont("Arial", "B", 24);
$pdf->SetTextColor(0, 102, 204);
$pdf->Cell(90, 12, $tiquete->getAsiento(), 0, 1);
$pdf->SetTextColor(0, 0, 0);

// Documento
$pdf->SetX(105);
$pdf->SetFont("Arial", "", 8);
$pdf->Cell(90, 4, "ID / DOCUMENTO", 0, 1);
$pdf->SetX(105);
$pdf->SetFont("Arial", "B", 11);
$pdf->Cell(90, 7, $documentoPasajero, 0, 1);

$pdf->Ln(5);


//
// ===========================
//        PIE DE PÁGINA
// ===========================
//
$pdf->SetY(-40);
$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
$pdf->Ln(3);

$horaAbordaje = date("H:i", strtotime($vuelo->getFecha_salida()) - 1800);
$pdf->SetFont("Arial", "I", 8);
$pdf->Cell(0, 4, "BOARDING TIME / HORA DE ABORDAJE: " . $horaAbordaje, 0, 1, "C");
$pdf->Cell(0, 4, "Please arrive at the gate 30 minutes before departure", 0, 1, "C");
$pdf->Ln(2);

$pdf->SetFont("Arial", "", 7);
$pdf->Cell(0, 4, "Tiquete ID: " . $id_tiquete, 0, 1, "C");
$pdf->Cell(0, 4, "Generated: " . date("Y-m-d H:i:s"), 0, 1, "C");


// Descargar PDF
$pdf->Output("I", "Pasabordo_" . $id_tiquete . ".pdf");
exit();

?>
