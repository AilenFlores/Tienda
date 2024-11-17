<?php
include_once "../../configuracion.php";
$datos = data_submitted();
    $objAbmCompraEstado = new AbmCompraEstado();
    $respuesta = $objAbmCompraEstado -> cancelarCompraEstado($datos);
    echo json_encode($respuesta);
?>