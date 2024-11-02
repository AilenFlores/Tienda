<?php 
include_once "../../../../../configuracion.php";
$data = data_submitted();
$objControl = new AbmMenu();
$list = convert_array($objControl->buscar($data));
echo json_encode($list);

?>


                                