<?php
ob_start();
session_start();

// ===============================================
//   1. PERMITIR ACCESO NORMAL O VIA QR
// ===============================================
// Si NO viene desde QR → validar sesión
$accesoQR = isset($_GET["qr"]) ? true : false;

if (!$accesoQR) {

    if (!isset($_SESSION["id"]) || !isset($_SESSION["rol"]) || $_SESSION["rol"] != "pasajero") {
        die("Acceso no autorizado");
    }
}

// ===============================================
//   2. VALIDAR ID DEL TIQUETE
// ===============================================
if (!isset($_GET["id_tiquete"]) || !is_numeric($_GET["id_tiquete"])) {
    die("ID de tiquete inválido.");
}

$id_tiquete = intval($_GET["id_tiquete"]);

// Cambiar directorio a raíz del proyecto
chdir(__DIR__ . '/../../');

// ===============================================
//   3. INCLUIR ARCHIVOS NECESARIOS
// ===============================================
require_once("logica/tiquete.php");
require_once("logica/Vuelo.php");
require_once("fpdf/fpdf.php");
require_once("phpqrcode/qrlib.php");

// ===============================================
//   4. CONSULTAR TIQUETE
// ===============================================
$tiquete = new Tiquete($id_tiquete);

if (!$tiquete->consultarPorId()) {
    die("Tiquete no encontrado.");
}

// Si es acceso normal, validar dueño del tiquete
if (!$accesoQR) {
    if ($_SESSION["id"] != $tiquete->getId_comprador()) {
        die("No tienes permiso para ver este pasabordo.");
    }
}

// ===============================================
//   5. CONSULTAR VUELO
// ===============================================
$vuelo = new Vuelo($tiquete->getId_vuelo());

if (!$vuelo->consultarPorId()) {
    die("Vuelo no encontrado.");
}

// ===============================================
//   6. DATOS DEL PASAJERO
// ===============================================
$nombrePasajero = $tiquete->getNombre_pasajero();
$documentoPasajero = $tiquete->getDocumento();

if (empty($nombrePasajero)) {
    die("Nombre de pasajero no disponible en el tiquete.");
}

// ===============================================
//   7. GENERAR QR
// ===============================================
$contenidoQR = "http://p1.itiud.org/presentacion/Pasajero/generarPasabordo.php?qr=1&id_tiquete=" . $id_tiquete;
$rutaQR = "imagenes/qr_tiquete_" . $id_tiquete . ".png";

if (!file_exists("imagenes")) {
    mkdir("imagenes", 0777, true);
}

QRcode::png($contenidoQR, $rutaQR, QR_ECLEVEL_L, 4);

ob_end_clean();

// ===============================================
//   8. GENERAR PDF
// ===============================================
$pdf = new FPDF("P", "mm", "Letter");
$pdf->AddPage();
$pdf->SetMargins(15, 15, 15);

// ENCABEZADO
$pdf->SetFillColor(200, 0, 0);
$pdf->Rect(0, 0, 220, 35, 'F');

$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont("Arial", "B", 24);
$pdf->Ln(10);
$pdf->Cell(0, 10, "BOARDING PASS", 0, 1, "C");

$pdf->SetFont("Arial", "", 10);
$pdf->Cell(0, 5, "PASABORDO DE VUELO", 0, 1, "C");

$pdf->Image($rutaQR, 165, 5, 35);

$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(10);

// NOMBRE
$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(0, 8, utf8_decode(strtoupper($nombrePasajero)), 0, 1);
$pdf->SetFont("Arial", "", 9);
$pdf->Cell(0, 5, "PASSENGER NAME / NOMBRE DEL PASAJERO", 0, 1);
$pdf->Ln(5);

// Línea
$pdf->SetDrawColor(200, 200, 200);
$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
$pdf->Ln(5);

// ORIGEN / DESTINO
$y_vuelo = $pdf->GetY();

$pdf->SetXY(15, $y_vuelo);
$pdf->SetFont("Arial", "B", 20);
$pdf->Cell(60, 10, strtoupper(substr($vuelo->getOrigen(), 0, 3)), 0, 1);
$pdf->SetX(15);
$pdf->SetFont("Arial", "", 8);
$pdf->Cell(60, 4, "FROM / ORIGEN", 0, 1);
$pdf->SetX(15);
$pdf->MultiCell(60, 4, utf8_decode($vuelo->getOrigen()));

$pdf->SetXY(75, $y_vuelo + 5);
$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(30, 10, ">>", 0, 0, "C");

$pdf->SetXY(105, $y_vuelo);
$pdf->SetFont("Arial", "B", 20);
$pdf->Cell(60, 10, strtoupper(substr($vuelo->getDestino(), 0, 3)), 0, 1);
$pdf->SetX(105);
$pdf->SetFont("Arial", "", 8);
$pdf->Cell(60, 4, "TO / DESTINO", 0, 1);
$pdf->SetX(105);
$pdf->MultiCell(60, 4, utf8_decode($vuelo->getDestino()));

$pdf->Ln(8);

// Línea
$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
$pdf->Ln(5);

// DETALLES DEL VUELO
$y_detalles = $pdf->GetY();

// Izquierda
$pdf->SetXY(15, $y_detalles);
$pdf->SetFont("Arial", "", 8);
$pdf->Cell(90, 4, "FLIGHT / VUELO", 0, 1);
$pdf->SetFont("Arial", "B", 14);
$pdf->SetX(15);
$pdf->Cell(90, 8, $vuelo->getId_vuelo(), 0, 1);

$pdf->SetFont("Arial", "", 8);
$pdf->SetX(15);
$pdf->Cell(90, 4, "DATE / FECHA", 0, 1);
$pdf->SetFont("Arial", "B", 12);
$pdf->SetX(15);
$pdf->Cell(90, 7, date("d/m/Y", strtotime($vuelo->getFecha_salida())), 0, 1);

$pdf->SetFont("Arial", "", 8);
$pdf->SetX(15);
$pdf->Cell(90, 4, "TIME / HORA", 0, 1);
$pdf->SetFont("Arial", "B", 12);
$pdf->SetX(15);
$pdf->Cell(90, 7, date("H:i", strtotime($vuelo->getFecha_salida())), 0, 1);

// Derecha
$pdf->SetXY(105, $y_detalles);
$pdf->SetFont("Arial", "", 8);
$pdf->Cell(90, 4, "SEAT / ASIENTO", 0, 1);

$pdf->SetFont("Arial", "B", 24);
$pdf->SetTextColor(0, 102, 204);
$pdf->SetX(105);
$pdf->Cell(90, 12, $tiquete->getAsiento(), 0, 1);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont("Arial", "", 8);
$pdf->SetX(105);
$pdf->Cell(90, 4, "ID / DOCUMENTO", 0, 1);
$pdf->SetFont("Arial", "B", 11);
$pdf->SetX(105);
$pdf->Cell(90, 7, $documentoPasajero, 0, 1);

// Pie
$pdf->SetY(-40);
$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
$pdf->Ln(3);

$horaAbordaje = date("H:i", strtotime($vuelo->getFecha_salida()) - 1800);
$pdf->SetFont("Arial", "I", 8);
$pdf->Cell(0, 4, "BOARDING TIME / HORA DE ABORDAJE: " . $horaAbordaje, 0, 1, "C");

$pdf->SetFont("Arial", "", 7);
$pdf->Cell(0, 4, "Tiquete ID: " . $id_tiquete, 0, 1, "C");
$pdf->Cell(0, 4, "Generated: " . date("Y-m-d H:i:s"), 0, 1, "C");

// Salida
$pdf->Output("I", "Pasabordo_" . $id_tiquete . ".pdf");
exit();
