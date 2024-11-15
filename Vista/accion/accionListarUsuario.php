<?php
include_once "../../configuracion.php";
$data = data_submitted();
$objControl = new AbmUsuarioLogin();
$session = new Session();
$usuario= $session->getUsuario();
$idUsuario = $usuario->getIdUsuario();
$list = convert_array($objControl->buscar(["idusuario" => $idUsuario]));
echo json_encode($list);
?>


                                