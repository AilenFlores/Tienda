<?php
include_once "../../../../configuracion.php";
    $datos = data_submitted();
    var_dump($datos);
    $objAbmCompraEstado = new AbmCompraEstado();
    $respuesta = $objAbmCompraEstado -> cancelarCompraCliente($datos);
    echo json_encode($respuesta);
?>