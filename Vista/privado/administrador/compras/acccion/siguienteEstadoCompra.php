<?php
include_once "../../../../../configuracion.php";
    $datos = data_submitted();
    $objAbmCompraEstado = new AbmCompraEstado();
    $respuesta = $objAbmCompraEstado -> siguienteEstadoCompra($datos);
    echo json_encode($respuesta);
?>