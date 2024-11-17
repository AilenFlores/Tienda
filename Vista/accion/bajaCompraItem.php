<?php
include_once "../../configuracion.php";
    $datos = data_submitted();
    if (isset($datos['idcompraitem'])){
        $objAbmItem = new AbmCompraitem();
        $objAbmItem -> eliminarItemDeCompra($datos);
    }
    header("Location:../paginas/carrito.php");
?>