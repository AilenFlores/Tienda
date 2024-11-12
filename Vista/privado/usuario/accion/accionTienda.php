<?php
include_once "../../../../configuracion.php";
$datos = data_submitted();
if (isset($datos['idproducto']) && isset($datos['cantidad'])){
    $objAbmCompra = new AbmCompra();
    $redireccion = $objAbmCompra -> agregarProductoACarrito($datos);
    header ($redireccion);
}else{
    header("Location:../productos.php?idproducto=" . $datos['idproducto']."&error=1"); 
}
?>