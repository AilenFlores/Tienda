<?php 
include_once "../../configuracion.php";
$data = data_submitted();
$objControl = new abmRol();
$list = convert_array($objControl->buscar($data));
echo json_encode($list);
?>


                                