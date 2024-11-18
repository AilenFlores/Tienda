<?php
include_once "../../configuracion.php";

$datos = data_submitted();
$objAbmCompra = new AbmCompra();

$response = $objAbmCompra->agregarProductoACarrito($datos);

header('Content-Type: application/json');
echo json_encode($response);

?>