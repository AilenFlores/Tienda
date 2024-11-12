<?php
include_once "../../../../configuracion.php";
    $objAbmCompra = new AbmCompra();
    $resp = $objAbmCompra -> cancelarCompra();
    header("Location:" . BASE_URL . "/vista/privado/usuario/tienda.php");
?>