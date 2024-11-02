<?php
include_once "../../../../../configuracion.php";
$data = data_submitted();
$retorno = ['respuesta' => false]; // Inicializa la respuesta como false por defecto

if (isset($data['idUsuario'])) {
    $objC = new AbmUsuarioLogin();
    $data["accion"]="borrar";
    $respuesta = $objC->abm($data);
    $retorno['respuesta'] = $respuesta;
    if (!$respuesta) {
        $retorno['errorMsg'] = "La acción ELIMINACIÓN no pudo concretarse";
    }
} else {
    $retorno['errorMsg'] = "ID de usuario no especificado";
}

echo json_encode($retorno);
?>
