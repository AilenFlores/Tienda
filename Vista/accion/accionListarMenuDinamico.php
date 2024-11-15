<?php
include_once "../../configuracion.php";
session_start();
$session = new Session();
$respuesta = [];

if ($session->validar()) { // Si la sesión está iniciada
    $roles = $session->getRol();
    $objMenuRol = new AbmMenuRol();
    foreach ($roles as $rol) {
        $respuesta = $objMenuRol->menuesByIdRol($rol); 
    }
}
echo json_encode($respuesta);
