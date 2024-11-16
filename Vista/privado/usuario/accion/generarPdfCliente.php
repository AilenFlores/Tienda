<?php
include_once "../../../../configuracion.php";
// Incluir la clase FPDF
require('../../../../Util/fpdf/fpdf.php');

$datos = data_submitted();
$objAbmCompraEstado = new PDF();

// Generar el PDF y guardar el archivo
$response = $objAbmCompraEstado->generarPdfCliente($datos);

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>

