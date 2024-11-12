<?php
include_once "../../../../configuracion.php";
$data = data_submitted(); 
$respuesta = false;
$data["accion"] = "editarActual";  
// Verifica si se ha enviado un ID de usuario para la modificación
if (isset($data['idUsuario'])) {
    $objC = new AbmUsuarioLogin();

    // Verifica si el nombre de usuario ya existe
    $objUsuarioExiste = convert_array($objC->buscar(['usnombre' => $data['usNombre']])); 
    if ($objUsuarioExiste) {
        $sms_error = "El usuario ya existe";
    }
    if (!$objUsuarioExiste) {
        $respuesta = $objC->abm($data);  
        if (!$respuesta) {
            $sms_error = "La acción de MODIFICACIÓN no pudo concretarse";
        } else {
            $respuesta = true;  
        }
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($sms_error)) {
    $retorno['errorMsg'] = $sms_error;
}

echo json_encode($retorno);
?>
