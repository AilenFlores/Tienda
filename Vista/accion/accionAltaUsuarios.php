<?php 
include_once "../../configuracion.php";
$data = data_submitted();
$respuesta = false;
if (isset($data['usNombre'])){
        $objC = new AbmUsuarioLogin();
        $data["accion"]="nuevo";
        $respuesta = $objC->abm($data);
        if (!$respuesta){
            $mensaje = " Nombre de usuario ya existente";
            
        }
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$mensaje;
   
}
 echo json_encode($retorno);
?>