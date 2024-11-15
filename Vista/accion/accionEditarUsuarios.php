<?php
include_once "../../configuracion.php";
$data = data_submitted();
$retorno = ['respuesta' => false]; 

$data["accion"] = "editar";

if (isset($data['idUsuario'])) {
    $data["idUsuario"] = intval($data["idUsuario"]);
    $objC = new AbmUsuarioLogin();
    // Verifica si el nombre de usuario ya existe mientras no sea el mismo usuario que se esta editandp
    $objUsuarioExiste = convert_array($objC->buscar(['usnombre' => $data['usNombre']]));
    if ($objUsuarioExiste && $objUsuarioExiste[0]['idUsuario'] != $data['idUsuario']) {
        $sms_error = "El nombre de usuario ya existe";
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
