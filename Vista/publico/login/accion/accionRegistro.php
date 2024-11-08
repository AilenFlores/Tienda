<?php
include_once "../../../../configuracion.php";
ob_start();
$data = data_submitted();
$respuesta = ['respuesta' => false, 'msg' => ''];
if (isset($data['usNombre'])) {
    $abmUsuario = new AbmUsuarioLogin();
    $data["accion"] = "nuevo";
     $resp = $abmUsuario->abm($data);
    if ($resp) {
        $respuesta['respuesta'] = true;
        $respuesta['msg'] = "Usuario registrado correctamente.";
    } else {
        $respuesta['respuesta'] = false;
        $respuesta['msg'] = "No se pudo registrar el usuario.";
    }
}

echo json_encode($respuesta);

