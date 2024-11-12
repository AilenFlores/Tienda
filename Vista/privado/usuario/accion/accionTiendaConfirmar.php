<?php
include_once "../../../../configuracion.php";
    $datos = data_submitted();
    if (isset($datos['idcompra'])){
        $objAbmCompra = new AbmCompra();
        $redireccion = $objAbmCompra -> finalizarCompra($datos);
        header($redireccion);
    }else{
        header("Location:../tiendaFinalizar.php?transaccion=fallo");
    }
?>