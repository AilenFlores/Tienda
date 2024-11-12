<?php
include_once "../../../../configuracion.php";
    $objAbmUsuario = new AbmUsuarioLogin();
    $arregloSalida = $objAbmUsuario -> listarCompraEstadoCliente();
    echo json_encode($arregloSalida);
?> 