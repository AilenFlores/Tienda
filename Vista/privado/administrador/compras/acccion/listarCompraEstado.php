<?php
include_once "../../../../../configuracion.php";
    $objAbmCompraEstado = new AbmCompraEstado();
    $arregloSalida = $objAbmCompraEstado -> listarCompraEstado();
    echo json_encode($arregloSalida);
?>