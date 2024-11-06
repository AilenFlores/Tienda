<?php
session_start(); 
include_once "../../../../configuracion.php";
$data = data_submitted();
$objControl = new AbmUsuarioLogin();
$list = convert_array($objControl->buscar(["idusuario" => $_SESSION['idusuario']]));
echo json_encode($list);
?>


                                