<?php 
include_once "../../configuracion.php";
$data = data_submitted();
$objControl = new AbmProducto();
$list = convert_array($objControl->buscar($data)); // Esto es un array de productos
// Convertir el array a JSON y devolverlo
echo json_encode($list);
?>
