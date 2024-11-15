<?php
include_once "../../configuracion.php";
$data = data_submitted();
$retorno = ['respuesta' => false];
if (isset($data['idmenu'])) {
    $objC = new AbmMenu();
    $menu=convert_array($objC->buscar(['idmenu' => $data['idmenu']]));
    $data["medeshabilitado"] = $menu[0]["medeshabilitado"];
    $data["accion"] = ($data['medeshabilitado'] != NULL) ? "habilitar" : "borrar";
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
