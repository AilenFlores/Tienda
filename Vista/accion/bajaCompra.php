<?php
include_once "../../configuracion.php";
    $objAbmCompra = new AbmCompra();
    $resp = $objAbmCompra -> cancelarCompra();
    header("Location:" . BASE_URL . "/vista/paginas/tienda.php");
?>