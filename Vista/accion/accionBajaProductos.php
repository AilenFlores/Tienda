<?php
include_once "../../configuracion.php";
$data = data_submitted();
$retorno = ['respuesta' => false]; // Inicializa la respuesta como false por defecto

if (isset($data['idproducto'])) {
    $objC = new AbmProducto();
    $producto=convert_array($objC->buscar(['idproducto' => $data['idproducto']]));
    $data["prodeshabilitado"] = $producto[0]["prodeshabilitado"];
    $data["accion"] = ($data['prodeshabilitado'] != NULL) ? "habilitar" : "borrar";
    $respuesta = $objC->abm($data);
    $retorno['respuesta'] = $respuesta;
    if (!$respuesta) {
        $retorno['errorMsg'] = "La acción ELIMINACIÓN no pudo concretarse";
    }
} else {
    $retorno['errorMsg'] = "ID de producto no especificado";
}

echo json_encode($retorno);
?>
