<?php
include_once "../../../../configuracion.php";
$resp = false;
$objTrans = new AbmRol(); // Instanciar el ABM de Usuario

if (!isset($datos)) {
    $datos = data_submitted();
} 
if (isset($datos['accion'])) {
    if ($datos['accion'] == 'listar') {
        $lista = convert_array($objTrans->buscar(null));          
    }
     else {
        $resp = $objTrans->abm($datos);
        if ($resp) {
            $mensaje = "La acción " . $datos['accion'] . " se realizó correctamente.";
        } else {
            $mensaje = "La acción " . $datos['accion'] . " no pudo concretarse.";
        }
        // Redirigir a la página de mensajes
        echo("<script>location.href = './index.php?msg=$mensaje';</script>");
    }
}
?>
