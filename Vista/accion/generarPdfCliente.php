<?php
include_once "../../configuracion.php";
require('../../Util/fpdf/fpdf.php');

$datos = data_submitted();

//Se buscan y guardan los datos del cliente.
$sesion = new Session();
$cliente = $sesion->getUsuario();
array_push($datos, $cliente);

//Se buscan y guardan los items de la compra.
$compraItem = new AbmCompraItem();
$items = $compraItem->buscar(['idcompra' => $datos['idcompra']]);
array_push($datos, $items);

// Generar el PDF y guardar el archivo
$pdf = new PDF();
$response = $pdf->generarPdfCliente($datos);

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>