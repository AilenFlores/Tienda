<?php 
include_once "../../../../configuracion.php";
$data = data_submitted();
$objControl = new AbmUsuarioLogin();
$list = convert_array($objControl->buscar(["idusuario"=>$_SESSION['idusuario']]));
//$list = convert_array($objControl->buscar(['idusuario'=>$ID]));//
echo json_encode($list);
?>


                                