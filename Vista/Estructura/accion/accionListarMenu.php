<?php
include_once "../../../configuracion.php";
session_start();
$session = new Session();
$respuesta = [];

if ($session->validar()) { // Si la sesión está iniciada
    $roles = $session->getRol();
    $objMenuRol = new AbmMenuRol();
    
    foreach ($roles as $rol) {
        $menues = $objMenuRol->menuesByIdRol($rol); 
        foreach ($menues as $objMenu) {
            if ($objMenu["medeshabilitado"] == NULL) {
                $respuesta[] = [
                    "url" => BASE_URL . "/vista/" . $objMenu["medescripcion"],
                    "nombre" => $objMenu["menombre"]
                ];
            }
        }
    }
}
echo json_encode($respuesta);
