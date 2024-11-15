<?php
include_once "../../configuracion.php";
$data = data_submitted();
$retorno = ['respuesta' => false]; 

$data["accion"] = "editar";

if (isset($data['idUsuario'])) {
    $data["idUsuario"] = intval($data["idUsuario"]);
    $objC = new AbmUsuarioLogin();
    $estado=$objC->existe($data);
    if (!$estado) {
        $sms_error = "El usuario ya existe en la base de datos";
    } else {
        $respuesta = $objC->abm($data);
        if (!$respuesta) {
            $sms_error = "La acción MODIFICACIÓN no pudo concretarse";
        } else {
            $retorno['respuesta'] = true;
        }
    }
}

if (isset($sms_error)) {
    $retorno['errorMsg'] = $sms_error;
}

echo json_encode($retorno);
?>
