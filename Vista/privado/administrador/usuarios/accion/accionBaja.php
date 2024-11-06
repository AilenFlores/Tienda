<?php
include_once "../../../../../configuracion.php";
$data = data_submitted();
$retorno = ['respuesta' => false];
if (isset($data['idUsuario'])) {
    $objC = new AbmUsuarioLogin();
    $usuario=convert_array($objC->buscar(['idusuario' => $data['idUsuario']]));
    $data["usDeshabilitado"] = $usuario[0]["usDeshabilitado"];
    $data["accion"] = ($data['usDeshabilitado'] != NULL) ? "habilitar" : "borrar";
    $respuesta = $objC->abm($data);
    $retorno['respuesta'] = $respuesta;
    if (!$respuesta) {
        $retorno['errorMsg'] = "La acción no pudo concretarse";
    }
} else {
    $retorno['errorMsg'] = "ID de usuario no especificado";
}

echo json_encode($retorno);
?>
