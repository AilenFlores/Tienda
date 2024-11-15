<?php
include_once "../../configuracion.php";
ob_start();
$data = data_submitted();
$respuesta = ['respuesta' => false, 'msg' => ''];
if (isset($data['usnombre'])) {
    $session = new Session();
    $resp = $session->iniciar($data["usnombre"], $data["uspass"]);
    if ($resp && $session->validar()) {
        $respuesta['respuesta'] = true;
        $respuesta['msg'] = "Bienvenido";
    } else {
        $respuesta['respuesta'] = false;
        $respuesta['msg'] = "Usuario o contraseña incorrectos.";
    }
}

echo json_encode($respuesta);

